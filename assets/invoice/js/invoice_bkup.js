$(document).ready(function () {
//    var id = $('#invoice_id').val(); // احصل على ID الفاتورة
//    if (id) {
//        loadInvoiceDetails(id); // نفّذ الدالة إذا كان هناك ID
//    }
//    
//    $('#addOrder').click(function () {
//        $('#orderModal').modal({
//            backdrop: 'static',
//            keyboard: false
//        });
//        $("#orderModal").on("shown.bs.modal", function () {
//            $('#orderForm')[0].reset();
//            $('.modal-title').html("<i class='fa fa-plus'></i> Add Order");
//            $('#action').val('addOrder');
//            $('#save').val('Save');
//            getTaxRate();
//        });
//    });
//
//    $("#orderModal").on("hidden.bs.modal", function () {
//        location.reload();
//    });

    $(document).on('click', '#checkAll', function () {
        $(".itemRow").prop("checked", this.checked);
    });
    $(document).on('click', '.itemRow', function () {
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });

    var count = $(".itemRow").length;
    $(document).on('click', '#addRows', function () {
        count++;
        var htmlRows = itemHTMLRows(count);
        $('#orderItem').append(htmlRows);
        loadItems(count);
    });
    $(document).on('click', '#removeRows', function () {
        $(".itemRow:checked").each(function () {
            $(this).closest('tr').remove();
        });
        $('#checkAll').prop('checked', false);
        calculateTotal();
    });
    $(document).on('blur', "[id^=quantity_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "[id^=price_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "#taxRate", function () {
        calculateTotal();
    });

    $(document).on('change', "[id^=items_]", function () {
        var id = $(this).attr('id');
        id = id.replace("items_", '');
        var itemId = $(this).val();

        //console.log(itemId);

        $('#price_' + id).html('');
        if (itemId != '') {
            $.ajax({
                url: baseurl + 'Student_payment/loadItemPrice',
                method: "POST",
                data: {itemId: itemId},
                success: function (data) {
                    $('#price_' + id).val(data);
                    if ($('#quantity_' + id).val() == '') {
                        $('#quantity_' + id).val(1);
                    }
                    calculateTotal();
                }
            });
        }
    });

    $("#orderListing").on('click', '.update', function () {
        //var id = $(this).attr("id");
        var id = $(this).closest('tr').find('.invoice_id').val();
        var action = 'getOrderDetails';
        $.ajax({
            url: baseurl + 'student_payment/get_invoice_details',
            method: "POST",
            data: {id: id, action: action},
            dataType: "json",
            success: function (respData) {
                $("#orderModal").on("shown.bs.modal", function () {
                    $('#orderForm')[0].reset();
                    $('#orderItem').html(""); // تفريغ العناصر القديمة

                    // البيانات العامة (مثل الإجمالي والضرائب والحالة)
                    $('#id').val(respData.data.id);
                    $('#subTotal').val(respData.data.gross_amount);
                    $('#taxAmount').val(respData.data.tax_amount);
                    $('#totalAftertax').val(respData.data.net_amount);
                    $('#status').val(respData.data.status);

                    var invoice_items = respData.invoice_items;
                    var itemCount = 1;

                    invoice_items.forEach(function (item) {
                        if (itemCount > 1) {
                            count++;
                            var htmlRows = itemHTMLRows(count);
                            $('#orderItem').append(htmlRows);
                        }

                        var currentRow = (itemCount > 1) ? count : 1;

                        // تحميل الفئات في الـ select
                        loadItems(currentRow);

                        // بعد تحميل الخيارات، نعيّن القيم
                        setTimeout(function () {
                            $('#items_' + currentRow).val(item['payments_category_id']);
                            $('#price_' + currentRow).val(item['payments_category_price']);
                            $('#quantity_' + currentRow).val(item['payments_category_quantity']);
                            $('#total_' + currentRow).val(item['payments_category_total']);
                            $('#itemIds_' + currentRow).val(item['id']);
                            calculateTotal();
                        }, itemCount * 200); // تأخير خفيف لتضمن تحميل الفئات قبل التعيين

                        itemCount++;
                    });

                    getTaxRate(); // تحميل الضريبة
                    $('.modal-title').html("<i class='fa fa-edit'></i> تعديل الفاتورة");
                    $('#action').val('updateOrder');
                    $('#save').val('تحديث');
                }).modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    });

//    $("#orderModal").on('submit', '#orderForm', function (event) {
//        event.preventDefault();
//        $('#save').attr('disabled', 'disabled');
//        var formData = $(this).serialize();
//        $.ajax({
//            url: "invoice_action.php",
//            method: "POST",
//            data: formData,
//            success: function (data) {
//                $('#orderForm')[0].reset();
//                $('#orderModal').modal('hide');
//                $('#save').attr('disabled', false);
//                orderRecords.ajax.reload();
//            }
//        })
//    });

//    $("#orderListing").on('click', '.delete', function () {
//        var id = $(this).attr("id");
//        var action = "deleteOrder";
//        if (confirm("Are you sure you want to delete this record?")) {
//            $.ajax({
//                url: "invoice_action.php",
//                method: "POST",
//                data: {id: id, action: action},
//                success: function (data) {
//                    orderRecords.ajax.reload();
//                }
//            })
//        } else {
//            return false;
//        }
//    });

});

function itemHTMLRows(count) {
    var htmlRows = '';
    htmlRows += '<tr>';
    htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
    htmlRows += '<td><select name="items[]" id="items_' + count + '" class="form-control"></select></td>';
    htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off"></td>';
    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" autocomplete="off"></td>';
    htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" autocomplete="off"></td>';
    htmlRows += '<input type="hidden" name="itemIds[]" id="itemIds_' + count + '" class="form-control">';
    htmlRows += '</tr>';
    return htmlRows;
}


function getTaxRate() {
    //console.log('getTaxRate');

    $.ajax({
        url: baseurl + 'Student_payment/getTaxRate',
        method: "POST",
        dataType: "json",
        data: {},
        success: function (respData) {

            respData.data.forEach(function (item) {

                if (item['tax_name'] == 'SGST') {
                    $("#taxRate2").val(item['percentage'])
                }
                if (item['tax_name'] == 'CGST') {
                    $("#taxRate1").val(item['percentage'])
                }
            });
        }
    });
}

function loadItems(id) {
    $.ajax({
        url: baseurl + 'Student_payment/loadItemsList',
        method: "POST",
        data: {},
        success: function (data) {
            $('#items_' + id).html(data);
        }
    });
}

function calculateTotal() {
    var totalAmount = 0;

    $("[id^='price_']").each(function () {
        var id = $(this).attr('id').replace("price_", '');
        var price = parseFloat($('#price_' + id).val()) || 0;
        var quantity = parseInt($('#quantity_' + id).val()) || 1;
        var total = price * quantity;

        $('#total_' + id).val(total.toFixed(2));
        totalAmount += total;
    });

    $('#subTotal').val(totalAmount.toFixed(2));

    // استرجاع نسبة الضريبة المئوية كمجرد رقم
    var taxRate = parseFloat($("#taxRate2").val()) || 0;

    // حساب قيمة الضريبة
    var taxAmount = (totalAmount * taxRate) / 100;
    $('#taxAmount').val(taxAmount.toFixed(2));

    var finalTotal = totalAmount + taxAmount;
    $('#totalAftertax').val(finalTotal.toFixed(2));
}

// تحديث الحساب عند تغيير القيم
$(document).on('input', "[id^=price_], [id^=quantity_]", function () {
    calculateTotal();
});

// تحديث الحساب عند تغيير نسبة الضريبة
$(document).on('change', "#taxRate2", function () {
    calculateTotal();
});

// تشغيل الحساب عند تحميل الصفحة للتأكد من دقة القيم الافتراضية
$(document).ready(function () {
    calculateTotal();
});
