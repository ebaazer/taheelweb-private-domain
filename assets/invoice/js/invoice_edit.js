$(document).ready(function () {

    var count = 1;

    // دالة إنشاء صف جديد للعناصر
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

    // دالة تحميل قائمة العناصر في select لكل صف
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

    // دالة لحساب الإجماليات
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

        var taxRate = parseFloat($("#taxRate2").val()) || 0;
        var taxAmount = (totalAmount * taxRate) / 100;
        $('#taxAmount').val(taxAmount.toFixed(2));

        var finalTotal = totalAmount + taxAmount;
        $('#totalAftertax').val(finalTotal.toFixed(2));
    }

    // دالة تحميل نسبة الضريبة
    function getTaxRate() {
        $.ajax({
            url: baseurl + 'Student_payment/getTaxRate',
            method: "POST",
            dataType: "json",
            success: function (respData) {
                respData.data.forEach(function (item) {
                    if (item['tax_name'] === 'SGST') {
                        $("#taxRate2").val(item['percentage']);
                    }
                    if (item['tax_name'] === 'CGST') {
                        $("#taxRate1").val(item['percentage']);
                    }
                });
                calculateTotal(); // إعادة حساب بعد تحميل الضريبة
            }
        });
    }

    // دالة تحميل بيانات الفاتورة وتعبئة النموذج
    function loadInvoiceDetails(id) {
        count = 1;

        $.ajax({
            url: baseurl + 'student_payment/get_invoice_details',
            method: "POST",
            data: {id: id, action: 'getOrderDetails'},
            dataType: "json",
            success: function (respData) {
                // تعبئة بيانات الفاتورة العامة
                $('#id').val(respData.data.id);
                $('#subTotal').val(respData.data.gross_amount);
                $('#taxAmount').val(respData.data.tax_amount);
                $('#totalAftertax').val(respData.data.net_amount);
                $('#status').val(respData.data.status);
                $('#taxRate2').val(respData.data.vat);
                $('#method').val(respData.data.payment_method);
                $('#amount_paid').val(respData.first_payment ? respData.first_payment.amount : 0);

                var invoice_items = respData.invoice_items;

                // تفريغ الجدول الحالي (إذا فيه)
                $('#orderItem').html('');

                // إذا لم يكن هناك عناصر، أضف صف فارغ جاهز للإدخال
                if (invoice_items.length === 0) {
                    var htmlRows = itemHTMLRows(1);
                    $('#orderItem').append(htmlRows);
                    loadItems(1);
                    return;
                }

                // تعبئة أول عنصر
                var firstItem = invoice_items[0];
                var htmlRows = itemHTMLRows(1);
                $('#orderItem').append(htmlRows);

                $.ajax({
                    url: baseurl + 'Student_payment/loadItemsList',
                    method: "POST",
                    success: function (data) {
                        $('#items_1').html(data);
                        $('#items_1').val(firstItem['payments_category_id']);
                        $('#price_1').val(firstItem['payments_category_price']);
                        $('#quantity_1').val(firstItem['payments_category_quantity']);
                        $('#total_1').val(firstItem['payments_category_total']);
                        $('#itemIds_1').val(firstItem['id']);
                        calculateTotal();
                    }
                });

                // تعبئة باقي العناصر لو موجودة
                for (let i = 1; i < invoice_items.length; i++) {
                    count++;
                    var htmlRows = itemHTMLRows(count);
                    $('#orderItem').append(htmlRows);

                    (function (rowId, itemData) {
                        $.ajax({
                            url: baseurl + 'Student_payment/loadItemsList',
                            method: "POST",
                            success: function (data) {
                                $('#items_' + rowId).html(data);
                                $('#items_' + rowId).val(itemData['payments_category_id']);
                                $('#price_' + rowId).val(itemData['payments_category_price']);
                                $('#quantity_' + rowId).val(itemData['payments_category_quantity']);
                                $('#total_' + rowId).val(itemData['payments_category_total']);
                                $('#itemIds_' + rowId).val(itemData['id']);
                                calculateTotal();
                            }
                        });
                    })(count, invoice_items[i]);
                }

                getTaxRate();
            }
        });
    }

    // تحميل الفاتورة عند وجود id (مثلاً في input مخفي)
    var invoiceId = $('#invoice_id').val();
    if (invoiceId) {
        loadInvoiceDetails(invoiceId);
    }

    // زر إضافة صف جديد
    $(document).on('click', '#addRows', function () {
        count++;
        var htmlRows = itemHTMLRows(count);
        $('#orderItem').append(htmlRows);
        loadItems(count);
    });

    // حذف الصفوف المحددة
    $(document).on('click', '#removeRows', function () {
        $(".itemRow:checked").each(function () {
            $(this).closest('tr').remove();
        });
        calculateTotal();
    });

    // تحديث الحساب عند تغيير السعر أو الكمية
    $(document).on('input', "[id^=price_], [id^=quantity_]", function () {
        calculateTotal();
    });

    // تحديث الحساب عند تغيير نسبة الضريبة
    $(document).on('change', "#taxRate2", function () {
        calculateTotal();
    });
});
