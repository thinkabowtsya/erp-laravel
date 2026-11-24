<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-overflow" style="overflow:auto;">
                        <input type="hidden" name="id" class="filled-row">
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    no bukti <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="nobukti" class="form-control lg-form filled-row" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl bukti<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" id="tglbukti" class="form-control lg-form datepicker filled-row" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    supplier <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supplierid" class="filled-row">
                                <input type="text" name="suppliernama" id="suppliernama" class="form-control lg-form supplier-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    TOP <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="top" class="filled-row">
                                <input type="text" name="topnama" id="topnama" class="form-control lg-form top-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    karyawan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="karyawanid" class="filled-row">
                                <input type="text" name="karyawannama" id="karyawannama" class="form-control lg-form karyawan-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl terima<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglterima" id="tglterima" class="form-control lg-form datepicker filled-row">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">discount</label>
                            </div>
                            <div class="col-md-1">
                                <div class="input-group">
                                    <input type="text" name="discountpersen" id="discountpersen" class="form-control text-right lg-form filled-row autonumeric-nozero" value="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text">% </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <label class="col-form-label">discount nilai</label>
                            </div>
                            <div class="col-md-1">
                                <input type="text" name="potongan" id="potongan" class="form-control text-right lg-form filled-row" value="0">
                            </div> 
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    keterangan
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="keterangan" id="keterangan" class="form-control lg-form filled-row">
                            </div>
                        </div>

                        <div class="overflow scroll-container mb-2">
                            <div class="table-container">
                                <table class="table table-lookup table-bold table-bindkeys" id="detailList">
                                    <thead>
                                        <tr id="table_header"></tr>
                                    </thead>
                                    <tbody id="table_body"></tbody>
                                    <tfoot id="table_footer">
                                        <!-- Footer content will be injected by JavaScript -->
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-warning btn-cancel btn-batal">
                            <i class="fa fa-times"></i>
                            Tutup </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()
    let discountNominalCheck = false 

    let valDiscountPersen
    let valDiscountNominal
    let isDiscountNominal = false
    let customerOld

    $(document).ready(function() {
        $("#crudForm [name]").attr("autocomplete", "off");
        $('#nopo').focus();

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="qty[]"]`, function(event) {
            setTotalDetail($(this))
           
            // discountNilai = $('#crudForm [name=potongan]').val().replace(/,/g, '')

            // if (discountNominalCheck) {
            //     setDiscountPersen()
            // }else {
            //     setDiscountNominal()
            // }
            // setDiscount()
            // setQtyPesananDetail($(this))
           
            // setGrandTotal()
        })

        $(document).on('input', `#table_body [name="qtyretur[]"]`, function(event) {
            setStokEdit($(this))
            checkJumlahQtyretur($(this))
            zeroQtyRetur($(this))
        })

        $(document).on('input', `#table_body [name="harga[]"]`, function(event) {
            setTotalDetail($(this))
            
            // if (discountNominalCheck) {
            //     setDiscountPersen()
            // }else {
            //     setDiscountNominal()
            // }

            // setDiscount()
            // setSubTotal()
            // setGrandTotal()
        })

        $(document).on('input', `#crudForm [name="potongan"]`, function(event) {
            // setDiscountPersen()
            // setDiscount()
            // setGrandTotal()
            isDiscountNominal = true
            
            setDiscountChange()
            setGrandTotal()

            

            discountNominalCheck = true
            valDiscountNilai = parseFloat($(this).val().replace(/,/g, ''))
        })

        $(document).on('input', `#crudForm .filled-row[name="discountpersen"]`, function(event) {
        //    setDiscountNominal()
        //    setDiscount()
        //    setGrandTotal()
        isDiscountNominal = false
        setDiscountChange()
        setGrandTotal()

            discountNominalCheck = false
           

            valDiscountPersen = parseFloat($(this).val().replace(/,/g, ''))
       })

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#crudForm').data('action') == 'edit') {

                $.ajax({
                    url: `{{ config('app.api_url') }}pembelianheader/editingat`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        id: $('#crudForm').find('[name=id]').val(),
                        btn: 'batal'
                    },
                    success: response => {
                        $("#crudModal").modal("hide")
                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.responseJSON)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
            } else {
                $("#crudModal").modal("hide")
            }
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            // let data = $('#crudForm .filled-row').serializeArray()
            let data = []
            let details = []

            data.push({
                name: `id`,
                value: Id
            })

            data.push({
                name: `nobukti`,
                value: form.find(`[name="nobukti"]`).val()
            })

            data.push({
                name: `tglbukti`,
                value: form.find(`[name="tglbukti"]`).val()
            })

            data.push({
                name: `supplierid`,
                value: form.find(`[name="supplierid"]`).val()
            })
            data.push({
                name: `suppliernama`,
                value: form.find(`[name="suppliernama"]`).val()
            })

            data.push({
                name: `top`,
                value: form.find(`[name="top"]`).val()
            })

            data.push({
                name: `topnama`,
                value: form.find(`[name="topnama"]`).val()
            })

            data.push({
                name: `karyawanid`,
                value: form.find(`[name="karyawanid"]`).val()
            })

            data.push({
                name: `karyawannama`,
                value: form.find(`[name="karyawannama"]`).val()
            })

            data.push({
                name: `tglterima`,
                value: form.find(`[name="tglterima"]`).val()
            })

            data.push({
                name: `keterangan`,
                value: form.find(`[name="keterangan"]`).val()
            })

            data.push({
                name: `subtotal`,
                value: $('#subtotal-calculate').text().replace(/,/g, '')
            })
            data.push({
                name: `total`,
                value: $('#total-calculate').text().replace(/,/g, '')
            })

            data.push({
                name: `potongan`,
                value: form.find(`[name="potongan"]`).val().replace(/,/g, '')
            })

            data.push({
                name: `discountpersen`,
                value: form.find(`[name="discountpersen"]`).val()
            })

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            data.push({
                name: 'periode',
                value: $('#formCrud').find('[name=periode]').val()
            })

            let periode = $('#formCrud').find('[name=periode]').val()

            $('#crudForm tbody tr.filled-row').each((index, element) => {
               
                const rowIndex = $(element).index();

                console.log(index,element,rowIndex,$(element));
                details[index] = {
                    id: $(element).find(`[name="id[]"]`).val(),
                    productid: $(element).find(`[name="productid[]"]`).val(),
                    productnama: $(element).find(`[name="productnama[]"]`).val(),
                    qty: AutoNumeric.getNumber($(form).find(`[name="qty[]"]`)[index]),
                    satuanid: $(element).find(`[name="satuanid[]"]`).val(),
                    satuannama: $(element).find(`[name="satuannama[]"]`).val(),
                    keterangandetail: $(element).find(`[name="keterangandetail[]"]`).val(),
                    keterangandetail2: $(element).find(`[name="keterangandetail2[]"]`).val(),
                    qtyretur: AutoNumeric.getNumber($(form).find(`[name="qtyretur[]"]`)[index]),
                    qtystok: AutoNumeric.getNumber($(form).find(`[name="stok[]"]`)[index]),
                    qtypesanan: AutoNumeric.getNumber($(form).find(`[name="qtypesanan[]"]`)[index]),
                    harga: AutoNumeric.getNumber($(form).find(`[name="harga[]"]`)[index]),
                    totalharga: AutoNumeric.getNumber($(form).find(`[name="totalharga[]"]`)[index]),
                    pesananfinalid: $(element).find(`[name="pesananfinalid[]"]`).val(),
                    pesananfinaldetailid: $(element).find(`[name="pesananfinaldetailid[]"]`).val(),

                };
            });

            // Convert the array to an object with indices as keys
            const detail = details.reduce((acc, item, index) => {
                acc[index] = item;
                return acc;
            }, {});

            // console.log(data)

            // Stringify the object
            const jsonString = JSON.stringify(detail);

            data.push({
                name: 'detail',
                value: jsonString
            })

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pembelianheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pembelianheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pembelianheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pembelianheader`
                    break;
            }
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    console.log(response);
                    id = response.data.id
                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    $('#crudForm').find('[name=periode]').val(dateFormat(response.data.tglpengiriman)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            tgldari: $('#tgldariheader').val(),
                            tglsampai: $('#tglsampaiheader').val()
                        }
                    }).trigger('reloadGrid');

                    if (id == 0) {
                        $('#detailGrid').jqGrid().trigger('reloadGrid')
                    }

                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessagesNew(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

        })
    })

    $('#crudModal').on('shown.bs.modal', () => {

        var crudModal = $('#crudModal')
        let form = $('#crudForm')
        setFormBindKeys(form)
        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }

        initLookup()
        initDatepicker()

       


    });

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        initDatepicker('datepickerIndex')
    })

    function checkJumlahQtyretur(element) {
        let idDetail = element.parents('tr').find('td [name="id[]"]').val();
        let id = element.parents('tr').find('td [name="id[]"]').val();

        $.ajax({
            url: `${apiUrl}pembelianheader/cekjumlahqtyretur`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                iddetail: idDetail,
                id: $('#crudForm').find('[name=id]').val()
            },
            success: response => {
                modalCheckQty(response, element);
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            },
        })
    }

    function modalCheckQty(response, element) {
        let qtyPembelian = response.qtypembelian
        let qtyretur = response.qtyretur

        let jumlahKeseluruhan = qtyPembelian + qtyretur

        let qtyreturCheck = parseFloat(element.parents('tr').find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))
        let originalqtyCheck = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
        let amountqtyCheck = originalqtyCheck - qtyreturCheck

        let qtyreturValue = qtyreturCheck

        console.log(qtyreturValue, jumlahKeseluruhan);
        let parentQtyRetur = element.parents('tr').find(`.qtyretur`)
        if (qtyreturValue > jumlahKeseluruhan && jumlahKeseluruhan != '') {
            element.parents('tr').find(` [name="qtyretur[]"]`).remove()

            let newQtyretur = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            parentQtyRetur.append(newQtyretur)

            elementParentQtyRetur = parentQtyRetur.find(`[name="qtyretur[]"]`)

            initAutoNumeric(parentQtyRetur.find(`[name="qtyretur[]"]`))
            initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

            showDialog(`Maksimal input qty retur = ${originalqtyCheck} !`);
        } else if (amountqtyCheck < 0) {
            element.parents('tr').find(` [name="qtyretur[]"]`).remove()

            let newQtyretur = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            parentQtyRetur.append(newQtyretur)

            elementParentQtyRetur = parentQtyRetur.find(`[name="qtyretur[]"]`)

            initAutoNumeric(parentQtyRetur.find(`[name="qtyretur[]"]`))
            initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

            // showDialog('Qty retur tidak boleh melebihi qty beli');
            showDialog(`Maksimal input qty retur = ${originalqtyCheck} !`);
        }
    }

    function setStokEdit(element) {
        let productid = element.parents('tr').find(` [name="productid[]"]`).val()

        $.ajax({
        url: `${apiUrl}pembelianheader/cekstokproduct`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
            Authorization: `Bearer ${accessToken}`
        },
        data: {
            productid: productid,
       
        },
        success: response => {
            console.log(response);
            initAutoNumeric($(element.closest('tr').find(`input[name="stok[]"]`)).val(response.data))

            let qtyStokVal = parseFloat(element.parents('tr').find(` [name="stok[]"]`).val().replace(/,/g, ''))
            let qtyVal = parseFloat(element.parents('tr').find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))
            let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))


            if (qtyVal > qtyStokVal) {
            showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtyStokVal}.`);

            let trIndex = $(element.parents('tr')).data('trindex')

            elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

            console.log(elementSecond);

            $(element.closest('tr').find(`input[name="qtyretur[]"]`)).remove()

            let newQtyEl = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            elementSecond.parents('tr').find(`.qtyretur`).append(newQtyEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))

            // setTotalHarga($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))
            // setSubTotal()
            // setTotal()
            }

        },
        error: error => {
            if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
            } else {
            showDialog(error.responseJSON)
            }
        },
        })

  }

  function zeroQtyRetur(element){
        let qtyVal = parseFloat(element.parents('tr').find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))

        let trIndex = $(element.parents('tr')).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

        console.log(elementSecond);

        if (element.val() == '') {
            $(element.closest('tr').find(`input[name="qtyretur[]"]`)).remove()

            let newQtyEl = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            elementSecond.parents('tr').find(`.qtyretur`).append(newQtyEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))
        }
       
  }

  function setDiscountChange(){
    
        let hitungDiscountNominal
        let hitungDiscountPersen = 0; 
        let totalsebelum = $('#subtotal-calculate').text().replace(/,/g, '')
        let discount = $(`#crudForm .filled-row[name="discountpersen"]`).val().replace(/,/g, '')
        let nominalDiscount = $(`#crudForm .filled-row[name="potongan"]`).val().replace(/,/g, '')
        
        if (isDiscountNominal) {
            if (totalsebelum > 0) {
                 hitungDiscountPersen = (nominalDiscount / totalsebelum)*100;
            }
 
            let getDiscountPersen = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountpersen"]`)[0]);
            getDiscountPersen.set(hitungDiscountPersen)
        }else{
            hitungDiscountNominal = totalsebelum * (discount / 100)

            let getDiscountNilai = AutoNumeric.getAutoNumericElement($(`#crudForm [name="potongan"]`)[0]);
            getDiscountNilai.set(hitungDiscountNominal)
        }

        if ($('#crudForm').data('action') != "add" && (customerOld == $(`#crudForm [name="supplierid"]`).val() )) {
            console.log('masuk kondisii');
            let getDiscountPersen = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountpersen"]`)[0]);
            let getDiscountNilai = AutoNumeric.getAutoNumericElement($(`#crudForm [name="potongan"]`)[0]);

            getDiscountPersen.set(discount)
            getDiscountNilai.set(nominalDiscount)
            
        }

        setGrandTotal()

    }

    function setQtys(element) {
        let qtyretur = parseFloat(element.parents('tr').find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))
        let qtyVal = $('#crudForm').find(`[name="qty[]"]`).val()

        let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
        let amountqty = originalqty - qtyretur

        if (isNaN(qtyretur) || qtyretur === 0) {
            amountqty = originalqty;
        }

        let qtyReturEl = element

        let parentQtyRetur = element.parents('tr').find(`.qtyretur`)
        // if(amountqty < 0){
        //     element.parents('tr').find(` [name="qtyretur[]"]`).remove()

        //     let newQtyretur = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

        //     parentQtyRetur.append(newQtyretur)

        //     elementParentQtyRetur = parentQtyRetur.find(`[name="qtyretur[]"]`)

        //     initAutoNumeric(parentQtyRetur.find(`[name="qtyretur[]"]`))
        //     initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqty))
        //     showDialog('tidak boleh minus')
        // }else{
        initAutoNumeric(element.parents('tr').find(`td [name="qty[]"]`).val(amountqty))
        // }

        setTotalDetail(parentQtyRetur.find(`[name="qtyretur[]"]`))

    }

    function setQtyPesananDetail(element) {
        let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        initAutoNumeric(element.parents('tr').find(`td [name="qtypesanan[]"]`).val(qty))
    }

    function setTotalDetail(element) {
        let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let harga = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
        let amount = qty * harga;
        
        initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(amount))

        setSubTotal()
    }

    function setQtyStok(productids, element) {

        $.ajax({
            url: `${apiUrl}pembelianheader/cekstokproduct`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                productid: productids
            },
            success: response => {
                // console.log(response.data)

                initAutoNumeric($(element.closest('tr').find(`input[name="stok[]"]`)).val(response.data))
                initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            },
        })
    }

    function setSubTotal() {
        let nominalDetails = $(`#detailList [name="totalharga[]"]`);

       
        let totaljual = 0;
        $.each(nominalDetails, (index, nominalDetail) => {
            let nominal = parseFloat($(nominalDetail).val().replace(/,/g, ''));
            
                if (isNaN(nominal)) {
                    nominal = 0
                }
                totaljual += nominal;
        });

        $('#subtotal-calculate').text(totaljual);
        initAutoNumericNoDoubleZero($('#subtotal-calculate'))

        setDiscountChange()
    }

    function setGrandTotal() {
        let grandtotal;
        let subtotal = $('#subtotal-calculate').text().replace(/,/g, '');
        let potongan = AutoNumeric.getNumber($(`#crudForm .filled-row[name="potongan"]`)[0])

        grandtotal = subtotal - potongan

        if (grandtotal < 0) {
            grandtotal = 0;
        }

        let discountAkhir = potongan
        let discountPersenAkhir = $(`#crudForm [name="discountpersen"]`).val().replace(/,/g, '')
       
        $('#disocuntpersen-calculate').text(discountPersenAkhir+'%')
        $('#discountnominal-calculate').text(discountAkhir)
        $('#total-calculate').text(grandtotal);

        initAutoNumericNoDoubleZero($('#discountnominal-calculate'));
        initAutoNumericNoDoubleZero($('#total-calculate'));
        initAutoNumeric($('#discountpersen-calculate'));
    }



    function createPembelianHeader() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        $('#crudModalTitle').text('create pembelian')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
        form.data('action', 'add')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')
        $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglterima]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                showDefault(form),
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                addRow()
                form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                form.find(`[name="nobukti"]`).prop('readonly', true)
                form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="grandtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="totalharga[]"]`).prop('readonly', true)
                form.find(`[name="qtypesanan[]"]`).prop('readonly', true)
                form.find(`[name="qtyretur[]"]`).prop('readonly', true)
                form.find(`[name="keterangancekpesanan[]"]`).prop('readonly', true).addClass('bg-white state-delete')

                form.find(`[name="stok[]"]`).prop('readonly', true)
                setDefault(form)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

        initAutoNumeric(form.find(`[name="discountpersen"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
    }

    var SetDefaultValue;

    function setDefault(form) {
        $.each(SetDefaultValue, (index, value) => {

            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
                element.val(value).trigger('change')
            } else {
                element.val(value)
            }
        })
    }

    function enableLookup() {
        let suppliernama = $('#crudForm').find(`[name="suppliernama"]`).parents('.input-group').children()
        suppliernama.find(`.lookup-toggler`).attr("disabled", true);
        suppliernama.find(`.button-clear`).attr("disabled", true);
        suppliernama.prop('readonly', true)
    }

    function editingAt(id, btn) {
        $.ajax({
            url: `{{ config('app.api_url') }}pembelianheader/editingat`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id: id,
                btn: btn
            },
            success: response => {
                editPembelianHeader(id)
            },
            error: error => {
                errors = JSON.parse(error.responseText);
                showConfirmForce(errors.errors.id, id)
            }
        })
    }

    let parentQtyStok

    function editPembelianHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('edit pembelian')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
       

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showPembelianHeader(form, id)
                    .then((response) => {
                        $('#crudModal').modal('show')
                        // $('.explode').slideUp();
                        // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        // form.find(`[name="nobukti"]`).prop('readonly', true)
                        // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                        // form.find(`[name="grandtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                        // form.find(`[name="stok[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="qty[]"]`).prop('readonly', true)

                        // form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')

                        $.each(response.detail, function(indexHeader, entry) {
                            if (entry.pesananpembelianid > '0') {
                                form.find(`[name="topnama"]`).parent('.input-group').find('.input-group-append button').attr('disabled',true);
                                form.find(`[name="karyawannama"]`).parent('.input-group').find('.input-group-append button').attr('disabled',true);
                                form.find(`[name="suppliernama"]`).parent('.input-group').find('.input-group-append button').attr('disabled',true);
                            }
                        })

                        initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                        initAutoNumeric(form.find(`[name="discountpersen"]`))

                        setSubTotal()
                       
                    
                        disableDelete(form,id)
                       
                       
                        // enableLookup()
                    })
            })
            .catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })



    }

    function disableDelete(form,id){
        $.ajax({
        url: `${apiUrl}pembelianheader/disableddelete/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        data:{
          id : id
        },
        success: response => {
          $.each(response.check, (index, value) => {
            console.log(value,index);
            if(value != ''){
                trRow = $('#crudForm').find(`#valueId_${value.id}`)

                trRow.find('#btnHapusDetail').prop('disabled',true)

            }
          })
        
        },
        error: error => {
          if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
        }
     })
    }

    function disabledDetail(detail) {
        detail.find(`[name="productnama[]"]`).prop('readonly', true)
        detail.find(`[name="productid[]"]`).prop('readonly', true)
        detail.find(`[name="satuanid[]"]`).prop('readonly', true)
        detail.find(`[name="satuannama[]"]`).prop('readonly', true)
        detail.find(`[name="qty[]"]`).prop('readonly', true)
        detail.find(`[name="harga[]"]`).prop('readonly', true)
        detail.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="stok[]"]`).prop('readonly', true)
        detail.find(`[name="keterangandetail2[]"]`).prop('readonly', true)

        let productnama = $(`#crudForm [name="productnama[]"]`)
        productnama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
        productnama.parent('.input-group').find('.button-clear').prop('disabled', true);

        let satuannama = $(`#crudForm [name="satuannama[]"]`)
        satuannama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
        satuannama.parent('.input-group').find('.button-clear').prop('disabled', true);

        $('#crudForm').find(`.delete-row`).prop('disabled', true);
    }

    function deletePembelianHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('delete pembelian')
        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
                  <i class="fa fa-save"></i>
                  Hapus
                `)
        form.find(`.sometimes`).hide()

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPembelianHeader(form, id),
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function viewPembelianHeader(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('view pembelian')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPembelianHeader(form, userId),
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                form.find(`.tbl_aksi`).hide()

                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

   
    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}pembelianheader/field_length`,
                    method: 'GET',
                    dataType: 'JSON',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    },
                    success: response => {
                        $.each(response.data, (index, value) => {
                            if (value !== null && value !== 0 && value !== undefined) {
                                form.find(`[name=${index}]`).attr('maxlength', value)
                            }

                            form.find(`[name=suppliernama]`).attr('maxlength', 100)

                        })
                        dataMaxLength = response.data
                        form.attr('has-maxlength', true)
                        resolve()
                    },
                    error: error => {
                        showDialog(error.statusText)
                        reject()
                    }
                })
            })
        } else {

            return new Promise((resolve, reject) => {
                $.each(dataMaxLength, (index, value) => {
                    if (value !== null && value !== 0 && value !== undefined) {
                        form.find(`[name=${index}]`).attr('maxlength', value)
                    }
                })
                resolve()
            })
        }
    }

    function showPembelianHeader(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}pembelianheader/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        console.log(response)

                        if (element.is('select')) {
                            if (response.data.suppliernama !== null) {
                                let newOption = new Option(response.data.suppliernama, value);
                                element.append(newOption);
                                element.val(value);
                                element.trigger('change');
                                element.on('select2:open', function() {

                                setTimeout(function() {
                                        $(".select2-search__field").focus();
                                    }, 50);
                                })

                                element.on('select2:opening', function() {
                                    setTimeout(function() {
                                        $('.select2-search__field').val(response.data.suppliernama).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'suppliernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'karyawannama') {
                            element.data('current-value', value)
                        }

                        if (index == 'topnama') {
                            element.data('current-value', value)
                        }
                    })

                    $('#detailList tbody').html('')
                    
                    let tableHeader = createTableHeaderEdit();
                    $('#detailList thead tr').html(tableHeader);

                  
                    $('#table_body').html('');

                    $.each(response.detail, (index, detail) => {
                        let newRow = createTableRowEdit(index, detail);
                        $('#table_body').append(newRow);

                        newRow.addClass('filled-row')
                        newRow.find(`[name="id[]"]`).val(detail.id)
                        newRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
                        newRow.find(`[name="keterangandetail2[]"]`).val(detail.keterangandetail2)
                        newRow.find(`[name="productid[]"]`).val(detail.productid)
                        newRow.find(`[name="productnama[]"]`).val(detail.productnama)
                        newRow.find(`[name="qty[]"]`).val(detail.qty)
                        newRow.find(`[name="originalqty[]"]`).val(detail.qty)
                        newRow.find(`[name="qtyretur[]"]`).val(detail.qtyretur)
                        newRow.find(`[name="qtypesanan[]"]`).val(detail.qtypesanan)
                        // newRow.find(`[name="stok[]"]`).val(detail.qtystok)
                        newRow.find(`[name="harga[]"]`).val(detail.harga)
                        newRow.find(`[name="totalharga[]"]`).val(detail.totalharga)
                        newRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                        newRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                        newRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) != undefined ? newRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) : 0;
                        newRow.find(`[name="pesananfinaldetailid[]"]`).val(detail.pesananfinaldetailid)
                        
                        SetOnInputDetail(newRow)
                        initLookupDetail(index);

                    });
                   
                    addRow(response.detail.length);
                    if (response.detail.pesananpembelianid > '0') {
                        form.find(`[name="productnama[]"]`).prop('readonly', true)
                        form.find(`[name="satuannama[]"]`).prop('readonly', true)
                        form.find(`[name="stok[]"]`).prop('readonly', true)
                        form.find(`[name="qtypesanan[]"]`).prop('readonly', true)
                        form.find(`[name="totalharga[]"]`).prop('readonly', true)
                        form.find(`[name="karyawannama"]`).prop('readonly', true)
                        form.find(`[name="suppliernama"]`).prop('readonly', true)
                        form.find(`[name="topnama"]`).prop('readonly', true)
                        form.find(`[name="tglterima"]`).prop('readonly', true)
                        form.find(`[name="keterangan"]`).prop('readonly', true)
                        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="grandtotal"]`).prop('readonly', true).addClass('bg-white state-delete')

                        form.find(`[name="karyawannama"]`).find(`.lookup-toggler`).attr("disabled", true)

                        let satuannama = detailRow.find(`[name="satuannama[]"]`).parents('.input-group').children()
                        satuannama.find(`.lookup-toggler`).attr("disabled", true)

                        let productnama = detailRow.find(`[name="productnama[]"]`).parents('.input-group').children()
                        productnama.find(`.lookup-toggler`).attr("disabled", true)
                        productnama.find(`.button-clear`).attr("disabled", true)

                        form.find('[name=tglterima]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        form.find('[name=suppliernama]').parents('.input-group').find('.lookup-toggler').attr('disabled', true)

                        let suppliernama = $(`#crudForm [name="suppliernama"]`)

                        
                        form.find(`[name="suppliernama"]`).parent('.input-group').find('.lookup-toggler').attr('disabled', true);
                        form.find(`[name="suppliernama"]`).parent('.input-group').find('.button-clear').attr('disabled', true);

                        let topnama = $(`#crudForm [name="topnama"]`)
                        form.find(`[name="topnama"]`).parent('.input-group').find('.lookup-toggler').attr('disabled', true);
                        form.find(`[name="topnama"]`).parent('.input-group').find('.button-clear').attr('disabled', true);


                        // enableLookup()

                        form.find('#btnHapusDetail').prop('disabled', true)
                    } else if (response.detail.pesananfinalid === 0) {
                        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="grandtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                    }

                    $.each(response.detail, (index, detail) => {
                        console.log(detail.pesananpembelianid > '0');
                        if (detail.pesananpembelianid > '0') {

                            var trElements = $('#detailList tbody tr');
                            trElements.each(function() {
                                var hasFilledRowClass = $(this).hasClass('filled-row');


                                if (!hasFilledRowClass) {
                                    $(this).find('input').prop('disabled', true).addClass('bg-white state-delete')
                                    $(this).find(`.delete-row`).prop('disabled', true)
                                    $(this).find(`.lookup-toggler`).prop('disabled', true)
                                    $(this).find(`.button-clear `).prop('disabled', true)
                                }
                            });
                        }

                    })
                    newCustomerChange = response.data.supplierid
                    selectIndex += 1;

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve(response)
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function createTableHeaderEdit() {
        let deviceType = detectDeviceType();

        if (deviceType === 'desktop') {
            return createTableHeaderDesktop();
        } else if (deviceType === 'mobile') {
            return createTableHeaderMobile();
        }
    }

    function createTableRowEdit(index, detail) {
        let selectIndex = index;
      
        if (detectDeviceType() === 'desktop') {
            return createTableRowsDesktop(selectIndex);
        } else if (detectDeviceType() === 'mobile') {
            return createTableRowsMobile(selectIndex);
        }
    }

    let selectIndex = 0

    function createTableHeaderDesktop(){
        return `
            <th style="width: 50px; min-width: 50px;">No.</th>
            <th style="width: 250px; min-width: 425px;">Produk</th>
            <th class="wider-qty" style="width: 170px; min-width: 190px;">Satuan</th>
            <th class="wider-qty text-right" style="width: 90px; min-width: 90px;">Qty</th>
            <th class="wider-stok" style="width: 90px; min-width: 90px; text-align:right"> Qty Stok</th>
            <th class="wider-qtyretur" style="width: 90px; min-width: 90px; text-align:right">Qty Retur</th>
            <th class="wider-qtypesanan" style="width: 90px; min-width: 90px; text-align:right">Qty Pesanan</th>
            <th class="wider-harga" style="width: 225px; min-width: 150px; text-align:right">Harga</th>
            <th class="wider-totalharga" style="width: 225px; min-width: 200px; text-align:right">Total</th>
            <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan</th>
            <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan 2</th>
            <th width="1%" class="tbl_aksi">Aksi</th>
        `
    }

    function createTableHeaderMobile(){
        return `
            <th style="width: 500px; min-width: 250px;">No. Produk</th>
        `
    }

    function createTableFooter(){
        return `
            <tr>
                <td colspan="9">
                <div class="row form-group">
                    <div class="col-12 col-md-10 text-lg-right">
                        <label class="col-form-label ">
                            subtotal
                        </label>
                        </div>
                        <div class="col-md-2 text-right">
                            <p class="text-right mt-2 font-weight-bold" id="subtotal-calculate">0</p>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">Potongan</label>
                        </div>
                        <div class="col-md-2 text-right">
                            <div class="row">
                                <div class="col-md-7">
                                    <p class="font-weight-bold mt-2" id="disocuntpersen-calculate">0%</p>
                                </div>
                                <div class="col-md-5">
                                    <p class="text-right mt-2 font-weight-bold" id="discountnominal-calculate">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">Total</label>
                        </div>
                        <div class="col-md-2 text-right">
                            <p class="text-right font-weight-bold mt-2" id="total-calculate">0</p>
                        </div>
                    </div>
                </td>
                <td colspan='3'></td>
            </tr>
        `
    }

    function createTableRowsDesktop(selectIndex){
        return $(`
            <tr class="detailList" data-trindex="${selectIndex}">
                <td class="table-bold">
                </td>
                <td class="table-bold">
                    <input type="hidden" name="id[]" class="form-control filled-row" value="0">
                    <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
                </td>
                <td class="table-bold">
                    <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                </td>
                <td class="table-bold">
                    <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                </td>
                <td class="table-bold">
                    <input type="text" name="stok[]" class="form-control lg-form autonumeric" autocomplete="off" value="0" readonly>
                </td>
                <td class="table-bold">
                    <input type="text" name="qtyretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                </td>
                <td class="table-bold">
                    <input type="text" name="qtypesanan[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0" readonly>
                </td>
                <td class="table-bold" id="harga${selectIndex}">
                    <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0">
                </td>
                <td class="table-bold" id="total${selectIndex}">
                    <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0" readonly>
                </td>
                <td class="table-bold">
                    <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                    <input type="text" name="pesananfinalid[]" class="form-control lg-form " autocomplete="off" value="0" hidden >
                </td>
                <td class="table-bold">
                    <input type="text" name="keterangandetail2[]" class="form-control lg-form " autocomplete="off" readonly >
                </td>
                <td class="tbl_aksi table-bold">
                    <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
            </tr>
        `)
    }

    function createTableRowsMobile(selectIndex){
        return $(`
            <tr>
                <td class="table-bold" >
                    <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px"><span class="no-urut"></span>. &ensp; produk</label>
                    <input type="hidden" name="id[]" class="form-control filled-row" value="0">
                    <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form numeric item-lookup${selectIndex}" autocomplete="off">
                    
                    <div class="d-flex align-items-center mt-2 mb-2">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label  label-mobile" style=" min-width: 25px;">QTY </label>
                                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                            </div>
                            <div class="col-6">
                                <label class="col-form-label label-mobile" style=" min-width: 50px;">SATUAN </label>
                                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}"  class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2 mb-2">
                    <div class="row">
                            <div class="col-6">
                                <label class="col-form-label mt-2 " style="font-size: 13px; min-width: 50px;">qty retur</label>
                                <input type="text" name="qtyretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                            </div>
                                <div class="col-6">
                                <label class="col-form-label mt-2 " >stok</label>
                                <input type="text" name="stok[]" class="form-control lg-form autonumeric" autocomplete="off" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2 mb-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY PESANAN</label>
                                            <input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label class="col-form-label  mt-2"  id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                                            <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0" >
                                        </div>
                                    </div>
                                </div>

                    <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">Total</label>
                    <input type="text" name="totalharga[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0" readonly>
                    <input type="text" name="pesananfinalid[]" class="form-control lg-form " autocomplete="off" value="0" hidden >
                    <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                    <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" >
                    <label class="col-form-label " style="font-size:13px">KETERANGAN 2</label>
                    <input type="text" name="keterangandetail2[]" class="form-control mb-2  lg-form" autocomplete="off" readonly>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
            </tr>
        `)
    }

    function addRow(show = 0) {
        formDetails = $('#detailList')

        let deviceType = detectDeviceType();
        let tableHeader = deviceType === 'desktop' ? createTableHeaderDesktop() : createTableHeaderMobile();
        let tableFooter = createTableFooter();

        $('#table_header').html(tableHeader);
        $('#table_footer').html(tableFooter);

        for (let i = show; i < 50; i++) {
            let selectIndex = i + 1;
            let urut = i + 1;
            let detailRow = deviceType === 'desktop' ? createTableRowsDesktop(selectIndex) : createTableRowsMobile(selectIndex, urut);
            $('#table_body').append(detailRow);

            let inputElements = $(`.detailList[data-trindex=${selectIndex}]`)
          
            rowLookup = selectIndex
            initLookupDetail(selectIndex);
            setRowNumbers(deviceType)
            SetOnInputDetail(inputElements)
            selectIndex++
        }
        initAutoNumeric(formDetails.find('.autonumeric'))
        initAutoNumericNoDoubleZero(formDetails.find('.autonumeric-nozero'))
        
    }

    function SetOnInputDetail(element){
        element.on('input', 'input[name="productnama[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                value.trim() !== "" || //produk nama
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||
                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="satuannama[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                value.trim() !== "" || //satuan nama
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||
                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="keterangandetail[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                value.trim() !== "" || //keterangan
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="keterangandetail2[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                value.trim() !== "" || //keterangan
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="harga[]"]', function() {
            setTotalHarga($(this))
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="totalharga[]"]', function() {

            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="qty[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="qtyretur[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="stok[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));

            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesananCek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

        element.on('input', 'input[name="qtypesanan[]"]', function() {
            let value = $(this).val();

            let currentRow = $(this).closest('tr');
            let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

            let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

            let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

            let qtyPesananCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



            let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

            let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

            let isRowFilled =
                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||

                qtycek !== 0 ||
                qtyReturCek !== 0 ||
                StokCek !== 0 ||
                qtyPesanancek !== 0 ||

                HargaCek !== 0 ||
                TotalHargaCek !== 0;

            if (isRowFilled) {
                currentRow.addClass('filled-row');
            } else {
                currentRow.removeClass('filled-row');
            }
        });

    }

    function initLookupDetail(index) {
        let rowLookup = index;

        $(`.item-lookup${rowLookup}`).lookup({
            title: 'Item Lookup',
            fileName: 'product',
            detail: true,
            miniSize: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    // supplierid: $('#crudForm').find('[name="supplierid"]').val(),
                    searching: 1,
                    valueName: `ItemId_${index}`,
                    id: `ItemId_${rowLookup}`,
                    searchText: `item-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Produk',
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (item, element) => {
                let item_id_input = element.parents('td').find(`[name="productid[]"]`);

                item_id_input.val(item.id);
                element.val(item.nama);

                element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
                element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)
                element.data('currentValue', element.val());

                element.parents('tr').find('td [name="qty[]"]').focus()

                let getHarga = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="harga[]"]')[0]);
                getHarga.set(item.hargabeli);

                checkFilledRowLookup(element)

                setTotalDetail(element)
                // setSubTotal()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
                item_id_input.val('');
                element.val('');
             
                let getHarga = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="harga[]"]')[0]);
                let getTotalHarga = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="totalharga[]"]')[0]);
                let getQty = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="qty[]"]')[0]);
                
                getHarga.set(0)
                getTotalHarga.set(0)
                getQty.set(0)

                let valueItem = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));



                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                    valueItem.trim() !== "" || //produk nama
                    currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||
                    qtycek !== 0 ||
                    qtyReturCek !== 0 ||
                    StokCek !== 0 ||
                    qtyPesanancek !== 0 ||

                    HargaCek !== 0 ||
                    TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                setTotalDetail(element)
                element.data('currentValue', element.val());
            },
        });

        $(`.satuan-lookup${rowLookup}`).lookup({
            title: 'Satuan Lookup',
            fileName: 'satuan',
            detail: true,
            miniSize: true,
            rowIndex: rowLookup,
            totalRow: 49,
            searching: 1,
            alignRightMobile: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `satuanId_${index}`,
                    id: `SatuanId_${rowLookup}`,
                    searchText: `satuan-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Satuan',
                };
            },
            onSelectRow: (satuan, element) => {

                let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`);
                satuan_id_input.val(satuan.id);
                element.val(satuan.nama);

                checkFilledRowLookup(element)

                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`).first();
                satuan_id_input.val('');
                element.val('');

                checkFilledRowLookup(element)
                element.data('currentValue', element.val());
            },
        });
    }

    function checkFilledRowLookup(element){
        let valueItem = $(element).val();

        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));

        let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

        let qtyPesananCek = (currentRow.find('input[name="qtypesanan[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtypesanan[]"]').val().replace(/,/g, ''));


        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
            valueItem.trim() !== "" || //produk nama
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail2[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturCek !== 0 ||
            StokCek !== 0 ||
            qtyPesanancek !== 0 ||

            HargaCek !== 0 ||
            TotalHargaCek !== 0;

        if (isRowFilled) {
            currentRow.addClass('filled-row');
        } else {
            currentRow.removeClass('filled-row');
        }
    }

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pembelianheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)


                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function deleteRow(row) {
        if (row.siblings().length == 0) {
            noUrut = 1
            row.remove()
            addRow()
        } else {
            row.remove()

        }
        row.remove()

        if (detectDeviceType() == "desktop") {
            setRowNumbers()
            setSubTotal()
        } else {
            updateUrut()
            setSubTotal()
        }
    }

    function cekValidasi(Id) {

    }

    function updateUrut() {
        let elements = $('#detailList tbody tr td.table-bold .label-top');

        elements.each((index, element) => {
            $(element).text(index + 1 + ". produk");
        });
    }

    function cekValidasiAksi(Id, Aksi) {
        if (Aksi == 'EDIT') {
            $.ajax({
                url: `{{ config('app.api_url') }}pembelianheader/${Id}/cekvalidasi`,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                    var error = response.error
                    if (error) {
                        showDialog(response)
                    } else {
                        editingAt(Id, 'EDIT')
                    }
                }
            })
        }
        if (Aksi == 'DELETE') {
            $.ajax({
                url: `{{ config('app.api_url') }}pembelianheader/${Id}/cekvalidasiaksi`,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                    var error = response.error
                    if (error) {
                        showDialog(response)
                    } else {
                        deletePembelianHeader(Id)
                    }
                }
            })
        }
    }

    function setRowNumbers(device = 'desktop') {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        if (device === 'mobile') {
           elements = $('.no-urut')
        }

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function initLookup() {
        $('.supplier-lookup').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplier_id',
                    searchText: 'supplier-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Supplier',
                }
            },
            onSelectRow: (supplier, element) => {
                valDiscountPersen = supplier.discountpersen
                valDiscountNominal = supplier.discountnilai

                $('#crudForm [name=supplierid]').first().val(supplier.id)
                element.val(supplier.nama)
               
                $('#crudForm [name=top]').first().val(supplier.top)
                $('#crudForm [name=topnama]').first().val(supplier.toptext)
                element.data('currentValue', element.val())

                let getPersen = AutoNumeric.getAutoNumericElement($('#crudForm [name=discountpersen]')[0]);
                let getNilai = AutoNumeric.getAutoNumericElement($('#crudForm [name=potongan]')[0]);

                // console.log(getPersen);
                getPersen.set(supplier.discountpersen || 0);
                getNilai.set(supplier.discountnilai);
                
                discountNilai = $('#crudForm [name=potongan]').val().replace(/,/g, '')
                
                if (discountNilai > 0 ) {
                    discountNominalCheck = true
                }else if(discountNilai == 0){
                    discountNominalCheck = false
                }
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplierid]').first().val('')
                $('#crudForm [name=top]').first().val('')

                element.val('')
                element.data('currentValue', element.val())

                let getPersen = AutoNumeric.getAutoNumericElement($('#crudForm [name=discountpersen]')[0]);
                let getNilai = AutoNumeric.getAutoNumericElement($('#crudForm [name=potongan]')[0]);
                getPersen.set(0);
                getNilai.set(0);

            }
        })

        $(`.top-lookup`).lookup({
            title: 'top Lookup',
            fileName: 'parameter',
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'TOP',
                    subgrp: 'TOP',
                    searching: 1,
                    valueName: `top`,
                    searchText: `top-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'top'
                };
            },
            onSelectRow: (top, element) => {
                $('#crudForm [name=top]').first().val(top.id)
                element.val(top.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let top_id_input = element.parents('td').find(`[name="top"]`).first();
                top_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $('.karyawan-lookup').lookup({
            title: 'karyawan Lookup',
            fileName: 'karyawan',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'karyawan_id',
                    searchText: 'karyawan-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'karyawan',
                }
            },
            onSelectRow: (karyawan, element) => {
                $('#crudForm [name=karyawanid]').first().val(karyawan.id)
                element.val(karyawan.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=karyawanid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    function approveKacab(id) {
        $('#approveKacab').modal('show')
        $('#formApproveKacab').find('[name=id]').val(id)
    }

    $(document).on('click', `#approvalKacab`, function(event) {
        event.preventDefault()

        let data = [];
        data.push({
            name: 'id',
            value: $('#formApproveKacab').find('[name=id]').val()
        })
        data.push({
            name: 'username',
            value: $('#formApproveKacab').find('[name=username]').val()
        })
        data.push({
            name: 'password',
            value: $('#formApproveKacab').find('[name=password]').val()
        })
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}pembelianheader/approvalkacab`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {
                if (response.status) {
                    $('#formApproveKacab').trigger("reset");
                    $("#approveKacab").modal('hide');
                    // if (!isAllowedForceEdit) {
                    editPembelianHeader($('#formApproveKacab').find('[name=id]').val())
                    // }
                } else {
                    showDialog('TIDAK ADA HAK AKSES')
                }
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages($('#formApproveKacab'), error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            },
        }).always(() => {
            $('#processingLoader').addClass('d-none')
            $(this).removeAttr('disabled')
        })
    })
</script>
@endpush()