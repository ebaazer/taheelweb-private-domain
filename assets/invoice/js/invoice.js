$(document).ready(function () {

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
                    $('#subTotal').val('');
                    $('#taxAmount').val('');
                    $('#totalAftertax').val('');
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
                        }, itemCount * 200);

                        itemCount++;
                    });

                    getTaxRate(); // تحميل الضريبة
                    $('.modal-title').html("<i class='fa fa-edit'></i> تعديل الفاتورة");
                    $('#action').val('updateOrder');
                    $('#save').val('تحديث');

                    // ✅ هنا تحط الاستدعاء
                    setTimeout(function () {
                        calculateTotal();
                    }, 300);


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

});

function itemHTMLRows(count) {
    var htmlRows = '';
    htmlRows += '<tr>';
    htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
    htmlRows += '<td><select name="items[]" id="items_' + count + '" class="form-control"></select></td>';
    // السعر من قاعدة البيانات
    htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" step="0.01" readonly></td>';
    // الكمية
    htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" step="1" autocomplete="off"></td>';
    // الخصم %
    htmlRows += '<td><input type="number" name="discount[]" id="discount_' + count + '" class="form-control discount" step="0.01" min="0" max="100" autocomplete="off"></td>';
    // السعر بعد الخصم
    htmlRows += '<td><input type="number" name="price_after[]" id="price_after_' + count + '" class="form-control price_after" step="0.01" readonly></td>';
    // الإجمالي
    htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" step="0.01" readonly></td>';
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

    // مرّ فقط على السعر الأصلي (من DB)، تجنّب price_after
    $(".price").each(function () {
        var priceInputId = $(this).attr('id'); // مثال: price_1
        var id = priceInputId.replace("price_", '');

        var price       = parseFloat($('#price_' + id).val()) || 0;   // السعر من DB
        var quantity    = parseFloat($('#quantity_' + id).val()) || 1;
        var discountPct = parseFloat($('#discount_' + id).val()) || 0;

        if (discountPct < 0)   discountPct = 0;
        if (discountPct > 100) discountPct = 100;

        // سعر الوحدة بعد الخصم
        var price_after = price * (1 - (discountPct / 100));
        if (price_after < 0) price_after = 0;

        // إجمالي الصف
        var rowTotal = price_after * quantity;

        // تحديث الحقول
        $('#price_after_' + id).val(price_after.toFixed(2));
        $('#total_' + id).val(rowTotal.toFixed(2));

        totalAmount += rowTotal;
    });

    // المجموع الفرعي بعد الخصم
    $('#subTotal').val(totalAmount.toFixed(2));

    // الضريبة
    var taxRate = parseFloat($("#taxRate2").val()) || 0;
    var taxAmount = (totalAmount * taxRate) / 100;
    $('#taxAmount').val(taxAmount.toFixed(2));

    // الصافي
    var finalTotal = totalAmount + taxAmount;
    $('#totalAftertax').val(finalTotal.toFixed(2));
}


// حساب مباشر عند إدخال الكمية أو الخصم
$(document).on('input', "[id^=quantity_], [id^=discount_]", function () {
    calculateTotal();
});

// الضريبة
$(document).on('input change', "#taxRate2", function () {
    calculateTotal();
});

// تشغيل الحساب عند تحميل الصفحة
$(document).ready(function () {
    calculateTotal();
});
