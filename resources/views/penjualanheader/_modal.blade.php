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
          <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
            <input type="hidden" name="id" class="filled-row">
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  no bukti <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control lg-form filled-row " readonly>
              </div>
            </div>
            <input type="text" name="nobuktipesananfinal" class="form-control lg-form filled-row " hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  tgl bukti<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" id="tglbukti" class="form-control lg-form datepicker  filled-row" readonly>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  customer <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="customerid" class="filled-row">
                <input type="text" name="customernama" id="customernama" class="form-control lg-form customer-lookup filled-row" autocomplete="off">
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
                  alamat pengiriman 
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="alamatpengiriman" id="alamatpengiriman" class="form-control lg-form form-control lg-form-lg-mobile filled-row">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL PENGIRIMAN<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglpengiriman" id="tglpengiriman" class="form-control lg-form datepicker filled-row">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                  <label class="col-form-label">discount</label>
              </div>
              <div class="col-md-1">
                  <div class="input-group">
                      <input type="text" name="discountpersen" id="discountpersen" class="form-control text-right lg-form filled-row" value="0">
                      <div class="input-group-append">
                          <span class="input-group-text">% </span>
                      </div>
                  </div>
              </div>
              <div class="col-1">
                  <label class="col-form-label">discount nilai</label>
              </div>
              <div class="col-md-1">
                  <input type="text" name="discountnilai" id="discountnilai" class="form-control text-right lg-form " value="0">
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

            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="status" class="filled-row">
                <input type="text" name="statusnama" id="statusnama" class="form-control lg-form status-lookup filled-row" autocomplete="off">
              </div>
            </div>
            --}}
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
  let modalBody = $('#crudForm').find('.modal-body').html()


  let importModal = $('#importModal')
  let importForm = importModal.find('form')
  let discountNominalCheck = false 

  let valDiscountPersen
  let valDiscountNominal
  let isDiscountNominal = false
  let customerOld

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");
    $('#nopo').focus();
    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="qty[]"]`, function(event) {
      setTotalHarga($(this))
      setTax()
    })

    $(document).on('input', `#table_body [name="qtyreturjual[]"]`, function(event) {
      setQtyReal($(this))
      checkJumlahQtyretur($(this))
      setQtyReturBeli($(this))
      zeroQtyReturJual($(this))
      

      // setTotalHarga($(this))
      // setSubTotal()
      // setTax()
      // setTotal()
    })

    $(document).on('input', `#table_body [name="qtyreturbeli[]"]`, function(event) {
      zeroQtyReturBeli($(this))
    })

    $(document).on('input', `#table_body [name="harga[]"]`, function(event) {
      setTotalHarga($(this))
      setTax()
    })

    $(document).on('input', `#crudForm .filled-row[name="tax"]`, function(event) {
      setTax()
      setTotal()
    })


    $(document).on('input', `#crudForm .filled-row[name="discountpersen"]`, function(event) {
      isDiscountNominal = false

      setDiscountChange()
      setTotal()

      discountNominalCheck = false
      

      valDiscountPersen = parseFloat($(this).val().replace(/,/g, ''))
    })

    $(document).on('input', `#crudForm [name="discountnilai"]`, function(event) {
      isDiscountNominal = true
      setDiscountChange()
      setTotal()

      

      discountNominalCheck = true
      valDiscountNilai = parseFloat($(this).val().replace(/,/g, ''))
    })

    $(document).on('click', '.btn-batal', function(event) {
      event.preventDefault()
      btnClickEdit()
    })

    function checkJumlahQtyretur(element) {
      let idDetail = element.parents('tr').find('td [name="id[]"]').val();
      let id = element.parents('tr').find('td [name="id[]"]').val();

      $.ajax({
        url: `${apiUrl}penjualanheader/cekjumlahqtyretur`,
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
          let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
          let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

          let sisaqtyretur = qty - response.data.totalqtyretur
          let amountqtyretur = qtyreturjual + response.data.totalqtyretur
         

          if (amountqtyretur > qty) {
            elementSecond = $(element.closest('tr').find(`[name="harga[]"]`))

            element.parents('tr').find(` [name="qtyreturbeli[]"]`).remove()
            element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()
            

            let newQtyReturEl = `<input type="text" name="qtyreturjual[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">`

            let newQtyReturBeliEl = `<input type="text" name="qtyreturbeli[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">`
            // console.log(sisaqtyretur, amountqtyretur)
            elementSecond.parents('tr').find(`.qtyreturjual`).append(newQtyReturEl)
            elementSecond.parents('tr').find(`.qtyreturbeli`).append(newQtyReturBeliEl)

            initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreturjual[]"]`)))
            initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreturbeli[]"]`)))
            initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreal[]"]`)).val(qty))

            showDialog(`Maksimal input qty retur = ${sisaqtyretur} !`)
          }

          if (qtyreturjual > qty) {
            elementSecond = $(element.closest('tr').find(`[name="harga[]"]`))
            element.parents('tr').find(` [name="qtyreturbeli[]"]`).remove()
            let newQtyReturBeliEl = `<input type="text" name="qtyreturbeli[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">`

            elementSecond.parents('tr').find(`.qtyreturbeli`).append(newQtyReturBeliEl)

            initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreturbeli[]"]`)))


            showDialog(`Maksimal input qty retur = ${qty} !`)
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

    // function modalCheckQty(response, element) {
    //   let qtyPenjualan = response.qtypenjualan
    //   let qtyretur = response.qtyretur

    //   let jumlahKeseluruhan = qtyPenjualan + qtyretur

    //   let qtyreturCheck = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
    //   let originalqtyCheck = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    //   let amountqtyCheck = originalqtyCheck - qtyreturCheck

    //   let qtyreturValue = qtyreturCheck

    //   // console.log(qtyreturValue,jumlahKeseluruhan);
    //   let parentQtyRetur = element.parents('tr').find(`.qtyretur`)
    //   if (qtyreturValue > jumlahKeseluruhan && jumlahKeseluruhan != '') {
    //     element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()

    //     let newQtyretur = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`

    //     parentQtyRetur.append(newQtyretur)

    //     elementParentQtyRetur = parentQtyRetur.find(`[name="qtyreturjual[]"]`)

    //     initAutoNumeric(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
    //     initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

    //     showDialog('Qty retur tidak boleh melebihi qty jual');
    //   } else if (amountqtyCheck < 0) {
    //     element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()

    //     let newQtyretur = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`

    //     parentQtyRetur.append(newQtyretur)

    //     elementParentQtyRetur = parentQtyRetur.find(`[name="qtyreturjual[]"]`)

    //     initAutoNumeric(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
    //     initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

    //     showDialog('Qty retur tidak boleh melebihi qty jual');
    //   }
    // }

    function btnClickEdit() {
      if ($('#crudForm').data('action') == 'edit') {
        $.ajax({
          url: `{{ config('app.api_url') }}penjualanheader/editingat`,
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
    }


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
        name: `nobukti`,
        value: form.find(`[name="nobukti"]`).val()
      })

      data.push({
        name: `id`,
        value: Id
      })

      data.push({
        name: `nobuktipesananfinal`,
        value: form.find(`[name="nobuktipesananfinal"]`).val()
      })

      data.push({
        name: `tglbukti`,
        value: form.find(`[name="tglbukti"]`).val()
      })

      data.push({
        name: `customerid`,
        value: form.find(`[name="customerid"]`).val()
      })

      data.push({
        name: `customernama`,
        value: form.find(`[name="customernama"]`).val()
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
        name: `alamatpengiriman`,
        value: form.find(`[name="alamatpengiriman"]`).val()
      })

      data.push({
        name: `tglpengiriman`,
        value: form.find(`[name="tglpengiriman"]`).val()
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
        name: `discount`,
        value: AutoNumeric.getNumber(form.find(`[name="discountpersen"]`)[0])
      })
      data.push({
        name: `total`,
        value: $('#total-calculate').text().replace(/,/g, '')
      })
      data.push({
          name: `discountpersen`,
          value: form.find(`[name="discountpersen"]`).val()
      })
      data.push({
          name: `discountnilai`,
          value: form.find(`[name="discountnilai"]`).val().replace(/,/g, '')
      })
      data.push({
        name: `tax`,
        value: form.find(`[name="tax"]`).val()
      })

      data.push({
        name: `taxamount`,
        value: form.find(`[name="taxamount"]`).val().replace(/,/g, '')
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
        details[rowIndex] = {
          id: $(element).find(`[name="id[]"]`).val(),
          pesananfinaldetailid: $(element).find(`[name="pesananfinaldetailid[]"]`).val(),
          productid: $(element).find(`[name="productid[]"]`).val(),
          productnama: $(element).find(`[name="productnama[]"]`).val(),
          qty: AutoNumeric.getNumber($(form).find(`[name="qty[]"]`)[rowIndex]),
          satuanid: $(element).find(`[name="satuanid[]"]`).val(),
          satuannama: $(element).find(`[name="satuannama[]"]`).val(),
          keterangandetail: $(element).find(`[name="keterangandetail[]"]`).val(),
          qtyreturjual: AutoNumeric.getNumber($(form).find(`[name="qtyreturjual[]"]`)[rowIndex]),
          qtyreturbeli: AutoNumeric.getNumber($(form).find(`[name="qtyreturbeli[]"]`)[rowIndex]),
          harga: AutoNumeric.getNumber($(form).find(`[name="harga[]"]`)[rowIndex]),
          totalharga: AutoNumeric.getNumber($(form).find(`[name="totalharga[]"]`)[rowIndex]),
        };
      });

      // Convert the array to an object with indices as keys
      const detail = details.reduce((acc, item, index) => {
        acc[index] = item;
        return acc;
      }, {});



      // Stringify the object
      const jsonString = JSON.stringify(detail);

      data.push({
        name: 'detail',
        value: jsonString
      })


      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penjualanheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penjualanheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penjualanheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penjualanheader`
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
          btnClickEdit()
          id = response.data.id
          $('#crudModal').find('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          $('#crudForm').find('[name=periode]').val(dateFormat(response.data.tglpengiriman)).trigger('change');
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              periode: periode,
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

    importForm.on('input', function() {
      importForm.data('hasChanged', true)
    })

    importForm.on('submit', function(event) {
      event.preventDefault()
      importItem(importForm)
    })

  })

  function zeroQtyReturJual(element) {
    let qtyVal = element.val()
    if (isNaN(qtyVal)) {
      qtyVal = '';
    }

    let trIndex = $(element.parents('tr')).data('trindex')
    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
    if (element.val() == '') {
      $(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).remove()
      let newQtyEl = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`
      elementSecond.parents('tr').find(`.qtyreturjual`).append(newQtyEl)
      initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturjual[]"]`)))
    }
  }

  function zeroQtyReturBeli(element) {
    let qtyVal = element.val()
    let trIndex = $(element.parents('tr')).data('trindex')
    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
    if (element.val() == '') {
      $(element.closest('tr').find(`input[name="qtyreturbeli[]"]`)).remove()
      let newQtyEl = `<input type="text" name="qtyreturbeli[]" class="form-control autonumeric" value="0">`
      elementSecond.parents('tr').find(`.qtyreturbeli`).append(newQtyEl)
      initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturbeli[]"]`)))
    }
  }

  function setQtys(element) {
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
    let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    let amountqty = originalqty - qtyreturjual
    if (isNaN(qtyreturjual) || qtyreturjual === 0) {
      amountqty = originalqty;
    }
    let parentQtyRetur = element.parents('tr').find(`.qtyreturjual`)
    initAutoNumeric(element.parents('tr').find(`td [name="qty[]"]`).val(amountqty))
    setTotalHarga(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
  }

  function setTotalHarga(element, id = 0) {
    let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

    let hargasatuan = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
    let amount = (qty - qtyreturjual) * hargasatuan;
    initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(amount))

    setSubTotal()
  }

  function generateTotalHarga(element) {
    let hargasatuan = parseFloat(element.parents('tr').find(`td [name="harga[]"]`).val().replace(/,/g, ''))
    initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(hargasatuan))
  }

  function setSubTotal() {
    let nominalDetails = $(`#detailList [name="totalharga[]"]`);

        let totaljual = 0;
        $.each(nominalDetails, (index, nominalDetail) => {
            let nominal = parseFloat($(nominalDetail).val().replace(/,/g, ''));
            // Menambahkan nilai nominal ke totaljual
           
            if (isNaN(nominal)) {
                nominal = 0
            }

            totaljual += nominal;
        });

        $('#subtotal-calculate').text(totaljual);
        initAutoNumericNoDoubleZero($('#subtotal-calculate'))

        setDiscountChange()
  }

  function setTotal() {
    let grandtotal;
        let total = $('#subtotal-calculate').text().replace(/,/g, '');
        
        let disc = $(`#crudForm [name="discountnilai"]`).val().replace(/,/g, '')
        let taxamount = $(`#crudForm .filled-row[name="taxamount"]`).val().replace(/,/g, '')
        grandtotal = total + taxamount - disc
        // let taxamount = AutoNumeric.getNumber($(`#crudForm .filled-row[name="taxamount"]`)[0])
        grandtotal = total - disc
        // Memastikan grand total tidak negatif
        if (grandtotal < 0) {
            grandtotal = 0;
        }

        // set discount akhir
        let discountAkhir = disc
        let discountPersenAkhir = $(`#crudForm [name="discountpersen"]`).val().replace(/,/g, '')
       
        $('#disocuntpersen-calculate').text(discountPersenAkhir+'%')
        $('#discountnominal-calculate').text(discountAkhir)
        $('#total-calculate').text(grandtotal);
      
        initAutoNumericNoDoubleZero($('#discountnominal-calculate'));
        initAutoNumeric($('#discountpersen-calculate'));
        initAutoNumericNoDoubleZero($(`#total-calculate`))
    }

    function setDiscountChange(){
        let hitungDiscountNominal
        let hitungDiscountPersen = 0; 
        let totalsebelum = $('#subtotal-calculate').text().replace(/,/g, '')
        let discount = $(`#crudForm .filled-row[name="discountpersen"]`).val().replace(/,/g, '')
        let nominalDiscount = $(`#crudForm [name="discountnilai"]`).val().replace(/,/g, '')
        
       
        if (isDiscountNominal) {
            if (totalsebelum > 0) {
                 hitungDiscountPersen = (nominalDiscount / totalsebelum)*100;
            }
 
            let getDiscountPersen = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountpersen"]`)[0]);
            getDiscountPersen.set(hitungDiscountPersen)
        }else{
            hitungDiscountNominal = totalsebelum * (discount / 100)

            let getDiscountNilai = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountnilai"]`)[0]);
            getDiscountNilai.set(hitungDiscountNominal)
        }

        if ($('#crudForm').data('action') != "add" && (customerOld == $(`#crudForm [name="customerid"]`).val() )) {
            let getDiscountPersen = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountpersen"]`)[0]);
            let getDiscountNilai = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountnilai"]`)[0]);

            getDiscountPersen.set(discount)
            getDiscountNilai.set(nominalDiscount)
            
        }

        setTotal()

    }

    function setDiscountNominal(){
        let totalsebelum = $('#subtotal-calculate').text().replace(/,/g, '')
        let discount = $(`#crudForm .filled-row[name="discountpersen"]`).val().replace(/,/g, '')

        let hitungDiscountNominal = totalsebelum * (discount / 100)

        $('#crudForm [name=discountnilai]').remove()

        let newDiscountNilai = `<input type="text" name="discountnilai" class="form-control autonumeric" value="${hitungDiscountNominal}">`;
        $('.col-md-1:last-child', '#crudForm').html(newDiscountNilai);

        // Inisialisasi AutoNumeric setelah menambahkan elemen baru
        initAutoNumericNoDoubleZero($('#crudForm [name=discountnilai]'));
        
    }

   
    function setDiscountPersen(){
        let nominalDiscount =  $(`#crudForm [name="discountnilai"]`).val().replace(/,/g, '')
        let totalsebelum = $('#subtotal-calculate').text().replace(/,/g, '')

        let hitungDiscountPersen = 0; 
        if(totalsebelum > 0){
            hitungDiscountPersen = (nominalDiscount / totalsebelum)*100; 
        }

        console.log(hitungDiscountPersen);

        $('#crudForm [name=discountpersen]').remove();

        let newDiscountPersen = `<div class="input-group">
                <input type="text" name="discountpersen" id="discountpersen" class="form-control text-right lg-form filled-row numbernoseparate" value="${hitungDiscountPersen}">
                <div class="input-group-append">
                    <span class="input-group-text">% </span>
                </div>
            </div>`;

        $('.col-md-1:nth-child(2)', '#crudForm').html(newDiscountPersen);

        initAutoNumeric($('#crudForm [name=discountpersen]'));

    }

  function setTax() {
    let result;
    let total = $('#subtotal-calculate').text().replace(/,/g, '')
    let taxlabel = $(`#crudForm .filled-row[name="tax"]`).val()
    result = (taxlabel / 100) * total;
    initAutoNumericNoDoubleZero($(`#taxamount`).val(result))
  }

  function setHarga(element) {
    let setharga;
    let totalharga = AutoNumeric.getNumber(element.parents('tr').find(`td [name="totalharga[]"]`)[0])
    let qty = AutoNumeric.getNumber(element.parents('tr').find(`td [name="qty[]"]`)[0])
  }

  function setStok(element) {
    let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
    let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    let qtystok = parseFloat(element.parents('tr').find(` [name="qtystok[]"]`).val().replace(/,/g, ''))

    if (isNaN(originalqty)) {
      if (qtystok < qty) {
        showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtystok}.`);

        let trIndex = $(element.parents('tr')).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

        $(element.closest('tr').find(`input[name="qty[]"]`)).remove()

        let newQtyEl = `<input type="text" name="qty[]" class="form-control autonumeric" value="0">`

        elementSecond.parents('tr').find(`#qty${trIndex}`).append(newQtyEl)
        initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))

      }
    } else {
      let qtypesanan = qtystok + originalqty
      if (qtypesanan < qty) {
        showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtypesanan}.`);
      }
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
        edit: true
      },
      success: response => {
        initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))

        let qtyStokVal = parseFloat(element.parents('tr').find(` [name="qtystok[]"]`).val().replace(/,/g, ''))
        let qtyVal = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))


        if (qtyVal > qtyStokVal) {
          showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtyStokVal}.`);

          let trIndex = $(element.parents('tr')).data('trindex')

          elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

          $(element.closest('tr').find(`input[name="qty[]"]`)).remove()

          let newQtyEl = `<input type="text" name="qty[]" class="form-control autonumeric" value="${originalqty}">`

          elementSecond.parents('tr').find(`#qty${trIndex}`).append(newQtyEl)
          initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))
          

          setTotalHarga($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))
          setSubTotal()
          setTax()
          setTotal()
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

  function setQtyReal(element){
    let qty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))

    
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

    if (isNaN(qtyreturjual)) {
      qtyreturjual = 0;
    }


    console.log('qty',qtyreturjual);

    let calculateQtyReal = qty-qtyreturjual

    element.parents('tr').find(` [name="qtyreal[]"]`).val(calculateQtyReal)

    initAutoNumeric($(element.parents('tr').find(`input[name="qtyreal[]"]`)))
  }

  function setQtyStok(productid, element) {

    $.ajax({
      url: `${apiUrl}pembelianheader/cekstokproduct`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        productid: productid
      },
      success: response => {
        console.log(response);
        initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))
        if (response.data == 0) {
          showDialog('produk ini tidak bisa dijual karena tidak ada stok')
          $(element.closest('tr').find(`input[name="productid[]"]`)).val("")
          $(element.closest('tr').find(`input[name="productnama[]"]`)).val("")
          $(element.closest('tr').find(`input[name="harga[]"]`)).val("")

          let trIndex = $(element.parents('tr')).data('trindex')
          $(element.closest('tr').find(`input[name="harga[]"]`)).remove()

          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`


          element.parents('tr').find(`#harga${trIndex}`).append(newHargaEl)

          $(element.closest('tr').find(`input[name="totalharga[]"]`)).prop('readonly', true)
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

  function setQtyReturBeli(element) {
    let qtyreturbeli = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

    if (isNaN(qtyreturbeli)) {
      qtyreturbeli = 0;
    }

    let newQtyEl = `<input type="text" name="qtyreturbeli[]" class="form-control autonumeric" value="${qtyreturbeli}">`

    elementSecond = $(element.closest('tr').find(`[name="harga[]"]`))

    element.parents('tr').find(` [name="qtyreturbeli[]"]`).remove()

    let newQtyReturEl = `<input type="text" name="qtyreturbeli[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="${qtyreturbeli}">`
    // console.log(sisaqtyretur, amountqtyretur)
    elementSecond.parents('tr').find(`.qtyreturbeli`).append(newQtyReturEl)

    initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreturbeli[]"]`)))
  }

  $('#crudModal').on('shown.bs.modal', () => {
    var crudModal = $('#crudModal')
    let form = $('#crudForm')
    setFormBindKeys(form)
    activeGrid = null

    initSelect2($(`[name="statusaktif"]`), true)

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

  function createPenjualanHeader() {
    let form = $('#crudForm')
    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
    form.data('action', 'add')
    $('#crudModalTitle').text('create penjualan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#table_body').html('')
    $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    var besok = new Date();
    besok.setDate(besok.getDate() + 1);


    $('#crudForm').find('[name=tglpengiriman]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

    Promise
      .all([
        showDefault(form),
        setStatusOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        addRow()
        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
        form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="totalharga[]"]`).prop('readonly', true)
        form.find(`[name="nobukti"]`).prop('disable', true)
        form.find(`[name="qtyreturjual[]"]`).prop('readonly', true)
        form.find(`[name="qtyreturbeli[]"]`).prop('readonly', true)
        form.find(`[name="discountpersenakhir"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
        setDefault(form)





      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
      initAutoNumericNoDoubleZero(form.find(`[name="discountnilai"]`))
      initAutoNumeric(form.find(`[name="discountpersen"]`));
  }

  function enableLookup() {

    let customernama = $('#crudForm').find(`[name="customernama"]`).parents('.input-group').children()
    let topnama = $('#crudForm').find(`[name="topnama"]`).parents('.input-group').children()
    let statusnama = $('#crudForm').find(`[name="statusnama"]`).parents('.input-group').children()
    let productnama = $('#crudForm').find(`[name="productnama[]"]`).parents('.input-group').children()
    let satuannama = $('#crudForm').find(`[name="satuannama[]"]`).parents('.input-group').children()

    productnama.prop('readonly', true)
    productnama.find(`.lookup-toggler`).attr("disabled", true);
    productnama.find(`.button-clear`).attr("disabled", true);

    satuannama.prop('readonly', true)
    satuannama.find(`.lookup-toggler`).attr("disabled", true);
    satuannama.find(`.button-clear`).attr("disabled", true);

    customernama.find(`.lookup-toggler`).attr("disabled", true);
    customernama.find(`.button-clear`).attr("disabled", true);
    customernama.prop('readonly', true)

    topnama.find(`.lookup-toggler`).attr("disabled", true);
    topnama.find(`.button-clear`).attr("disabled", true);
    topnama.prop('readonly', true)

    statusnama.find(`.lookup-toggler`).attr("disabled", true);
    statusnama.find(`.button-clear`).attr("disabled", true);
    statusnama.prop('readonly', true)
  }

  // function editingAt(id, btn) {
  //   $.ajax({
  //     url: `{{ config('app.api_url') }}penjualanheader/editingat`,
  //     method: 'POST',
  //     dataType: 'JSON',
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     data: {
  //       id: id,
  //       btn: btn
  //     },
  //     success: response => {
  //       // isEdited = response.isEdited
  //       // if (isEdited) {
  //       //     approveKacab(id)
  //       // } else {
  //       editPenjualanHeader(id)
  //       // }
  //     },
  //     error: error => {
  //       errors = JSON.parse(error.responseText);
  //       if (errors.message) {
  //         showDialogEditAllMessage(errors.message)
  //       } else {
  //         showConfirmForce(errors.errors.id, id)
  //       }

  //     }
  //   })
  // }

  function editingAt(id, btn) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/editingat`,
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
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function editPenjualanHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('edit penjualan')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
    form.find(`.sometimes`).hide()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusOptions(form),
        editingAt(id, 'EDIT'),
        getMaxLength(form),
      
      ])
      .then(() => {
        showPenjualanHeader(form, id)
          .then((response) => {
            $('#crudModal').modal('show')
            form.find(`[name="totalharga[]"]`).prop('readonly', true)
            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true)
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="discount"]`).prop('readonly', true).addClass(
                                'bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
              form.find(`[name="discountpersenakhir"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
            }

            initAutoNumeric(form.find(`[name="discountpersen"]`));
            initAutoNumericNoDoubleZero(form.find(`[name="discountnilai"]`))
            
            setTax()
            setSubTotal()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
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

  function deletePenjualanHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('delete penjualan')
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
        setStatusOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPenjualanHeader(form, id)
          .then((response) => {

            $('#crudModal').modal('show')
            form.find(`[name="totalharga[]"]`).prop('readonly', true)
            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
              form.find(`[name="discountpersenakhir"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
            }
            initAutoNumeric(form.find(`[name="discountpersen"]`));
            initAutoNumericNoDoubleZero(form.find(`[name="discountnilai"]`))
            
            setTax()
            setSubTotal()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function viewPenjualanHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('view penjualan')
    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPenjualanHeader(form, userId)
          .then((response) => {
            $('#crudModal').modal('show')
            form.find(`[name="totalharga[]"]`).prop('readonly', true)
            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true)
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
            }

            form.find(`.tbl_aksi`).hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="total"]`))
  }


  const setStatusOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=status]').empty()
      relatedForm.find('[name=status]').append(
        new Option('-- PILIH STATUS --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: "STATUS",
          subgrp: "STATUS"
        },
        success: response => {
          response.data.forEach(status => {
            let option = new Option(status.text, status.id)

            relatedForm.find('[name=status]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}penjualanheader/field_length`,
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

              form.find(`[name=customernama]`).attr('maxlength', 100)

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

  function disabledQtyRetur(form, id) {
    $.ajax({
      url: `${apiUrl}penjualanheader/disabledqtyretur/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        id: id
      },
      success: response => {
        console.log(response);
        $.each(response.check, (index, value) => {

          if (value.nobuktipembelian == '') {
            $('#crudForm').find(`[name="qtyreturjual[]"]`).prop('readonly', true)
            $('#crudForm').find(`[name="qtyreturbeli[]"]`).prop('readonly', true)
          }
        })
        // $.each(response.data, (index, value) => {
        //   if (value !== null && value !== 0 && value !== undefined) {
        //     form.find(`[name=${index}]`).attr('maxlength', value)
        //   }
        // })

        // form.attr('has-maxlength', true)
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

  function showPenjualanHeader(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}penjualanheader/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              if (response.data.customer_name !== null) {
                let newOption = new Option(response.data.customer_name, value);
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
                    $('.select2-search__field').val(response.data.customer_name).trigger('input');
                    $('.select2-search__field').focus();
                  }, 50);

                });
              }
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }


            if (index == 'customernama') {
              element.data('current-value', value)
            }

            if (index == 'topnama') {
              element.data('current-value', value)
            }

            if (index == 'statusnama') {
              element.data('current-value', value)
            }

          })

          $('#detailList tbody').html('')

          $.each(response.detail, (index, detail) => {
              let newRow = createTableRowEdit(index, detail);
              $('#table_body').append(newRow);

              newRow.addClass('filled-row')
              newRow.find(`[name="pesananfinaldetailid[]"]`).val(detail.pesananfinaldetailid)
              newRow.find(`[name="id[]"]`).val(detail.id)
              newRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              newRow.find(`[name="productid[]"]`).val(detail.productid)
              newRow.find(`[name="productnama[]"]`).val(detail.productnama)
              newRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              newRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              newRow.find(`[name="qty[]"]`).val(detail.qty)
              newRow.find(`[name="qtyreal[]"]`).val(detail.qty)
              newRow.find(`[name="originalqty[]"]`).val(detail.qty)
              newRow.find(`[name="qtyreturjual[]"]`).val(detail.qtyreturjual)
              newRow.find(`[name="qtyreturbeli[]"]`).val(detail.qtyreturbeli)
              newRow.find(`[name="harga[]"]`).val(detail.harga)
              newRow.find(`[name="totalharga[]"]`).val(detail.totalharga)
              
              SetOnInputDetail(newRow)
              initLookupDetail(index);

             

          });
          
          addRow(response.detail.length);

          if (response.data.pesananfinalid > 0) {
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

          newCustomerChange = response.data.customerid
          selectIndex += 1;
         
          disabledQtyRetur(form, userId)
         
          selectIndex += 1;
          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function disabledInput(detailRow) {

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
        <th style="width: 50px; min-width: 50px;" >No.</th>
        <th style="width: 250px; min-width: 425px;">Produk</th>
        <th class="wider-qty text-right" style="width: 90px; min-width: 90px;">Qty</th>
        <th class="wider-qty text-right" style="width: 90px; min-width: 90px;">Qty Real</th>
        <th class="wider-qty" style="width: 170px; min-width: 190px;">Satuan</th>
        <th class="wider-keterangan" style="width: 300px; min-width: 225px;">Keterangan</th>
        <th class="wider-qty text-right"  style="width: 90px; min-width: 90px;">Qty Retur Jual</th>
        <th class="wider-qty text-right"  style="width: 90px; min-width: 90px;">Qty Retur Beli</th>
        <th class="wider-harga text-right" style="width: 120px; min-width: 150px;">Harga</th>
        <th class="wider-keterangan text-right" style="width: 120px; min-width: 200px;">Total</th>
        <th  style="width: 100px; min-width: 100px;" class="tbl_aksi">Aksi</th>
    `;
  }

  function createTableHeaderMobile(){
    return `
      <th style="width: 500px; min-width: 250px;">No. Produk</th>
    `
  }

  function createTableFooter() {
        return `
            <tr>
                <td colspan="10">
                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">Sub Total</label>
                        </div>
                        <div class="col-md-2 text-right">
                            <p class="text-right mt-2 font-weight-bold" id="subtotal-calculate">0</p>
                        </div>
                    </div>
                    <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row small-input" value="0" hidden>
                    <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form filled-row" value="0" hidden>
                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">Discount</label>
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
                <td></td>
            </tr>
        `;
   }

   function createTableRowsDesktop(selectIndex){
      return $(`
            <tr class="detailList" data-trindex="${selectIndex}" >
              <td  class="table-bold">   
            </td>
            <td class="table-bold">
              <input type="hidden" name="pesananfinaldetailid[]"  class="form-control filled-row detail_stok_${selectIndex}">
              <input type="hidden" name="id[]" class="form-control filled-row" value="0">
              <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
              </td>
              <td id="qty${selectIndex}" class="table-bold" id="qty${selectIndex}">
                <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                <input type="hidden" name="originalqty[]" class="form-control lg-form autonumeric">
              </td>
              <td id="qty${selectIndex}" class="table-bold">
                <input type="text" name="qtyreal[]" class="form-control lg-form autonumeric" autocomplete="off" value="0" readonly>
              </td>
              <td  class="table-bold">
                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
              </td>
              <td  class="table-bold">
                <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
              </td>
              <td  class="table-bold">
                <input type="text" name="qtyreturjual[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td  class="table-bold">
                <input type="text" name="qtyreturbeli[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td id="harga${selectIndex}" class="table-bold">
                <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
              </td>
              <td id="total${selectIndex}" class="table-bold">
                <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero  text-right" autocomplete="off" value="0" >
              </td>
              <td class="tbl_aksi table-bold">
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
            </tr>`
        )
   }

  function createTableRowsMobile(selectIndex) {
    return $(`
        <tr>
            
            <td class="table-bold" >
              <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px"><span class="no-urut"></span>. &ensp; produk</label>
              <input type="hidden" name="id[]" class="form-control filled-row detail_stok_${selectIndex}" value="0">
                <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form numeric item-lookup${selectIndex}" autocomplete="off">

                
           
                <div class="d-flex align-items-center mt-2 mb-2">
                  <div class="row">
                    <div class="col-6">
                    <label class="col-form-label label-mobile" style=" min-width: 25px;">QTY </label>
                    <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
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
                      <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                      <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                    </div>

                    <div class="col-6">
                      <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">Total</label>
                      <input type="text" name="totalharga[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label" min-width: 50px;">QTY RETUR JUAL</label>
                            <input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="0">
                          </div>

                          <div class="col-6">
                            <label class="col-form-label" min-width: 50px;">QTY RETUR BELI</label>
                            <input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="0">
                          </div>
                        </div>
                    </div> 
                <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">
                <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
             
        </tr> `)

  }



  function addRow(show = 0){
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

        $(detailRow).find('input[name="pesananfinaldetailid[]"]').val(0)
        $('#table_body').append(detailRow);

        let inputElements = $(`.detailList[data-trindex=${selectIndex}]`)
      
        rowLookup = selectIndex
        initLookupDetail(selectIndex);
        setRowNumbers(deviceType)
        // SetOnInputDetail(inputElements)
        selectIndex++
    }
    initAutoNumeric(formDetails.find('.autonumeric'))
    initAutoNumericNoDoubleZero(formDetails.find('.autonumeric-nozero'))
  }

  function SetOnInputDetail(element){
         // Jika baris diisi, tambahkan kelas 'filled-row'
      element.on('input', 'input[name="productnama[]"]', function() {
        let value = $(this).val();

        let currentRow = $(this).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          value.trim() !== "" || //produk nama
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          value.trim() !== "" || //satuan nama
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          value.trim() !== "" || //keterangan
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
          HargaCek !== 0 ||
          TotalHargaCek !== 0;

        if (isRowFilled) {
          currentRow.addClass('filled-row');
        } else {
          currentRow.removeClass('filled-row');
        }
      });

      element.on('input', 'input[name="qtyreturjual[]"]', function() {
        let value = $(this).val();

        let currentRow = $(this).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
          HargaCek !== 0 ||
          TotalHargaCek !== 0;

        if (isRowFilled) {
          currentRow.addClass('filled-row');
        } else {
          currentRow.removeClass('filled-row');
        }
      });

      element.on('input', 'input[name="qtyreturbeli[]"]', function() {
        let value = $(this).val();

        let currentRow = $(this).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
          HargaCek !== 0 ||
          TotalHargaCek !== 0;

        if (isRowFilled) {
          currentRow.addClass('filled-row');
        } else {
          currentRow.removeClass('filled-row');
        }
      });
    }

  function cekValidasiAksi(Id, Aksi) {
    if (Aksi == 'EDIT') {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/${Id}/cekvalidasi`,
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
            // editingAt(Id, 'EDIT')
            if (Aksi == 'EDIT') {
              // editPenjualanHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePenjualanHeader(Id)
            }
          }
        }
      })
    }
    if (Aksi == 'DELETE') {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/${Id}/cekvalidasiaksi`,
        method: 'POST',
        dataType: 'JSON',
        data: {
          btn: 'DELETE'
        },
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        success: response => {
          var error = response.error
          if (error) {
            showDialog(response)
          } else {
            deletePenjualanHeader(Id)
          }
        }
      })
    }
  }


  function initLookupDetail(index) {
    let rowLookup = index;

    $(`.item-lookup${rowLookup}`).lookup({
      title: 'Item Lookup',
      fileName: 'product',
      detail: false,
      miniSize: false,
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: `ItemId_${index}`,
          id: `ItemId_${rowLookup}`,
          searchText: `item-lookup${rowLookup}`,
          singleColumn: true,
          hideLabel: true,
          title: 'Produk',
          customerid: $('#crudForm').find('[name=customerid]').val()
          // typeSearch: 'ALL',
        };
      },
      onSelectRow: (item, element) => {

        let item_id_input = element.parents('td').find(`[name="productid[]"]`);

        element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
        element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)

        let getHargaJual = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="harga[]"]')[0]);
        getHargaJual.set(item.hargajual);

        element.parents('tr').find('td [name="qty[]"]').focus()

        item_id_input.val(item.id);
        element.val(item.nama);

        checkFilledRowLookup(element)

        element.data('currentValue', element.val());
        element.parents('tr').find('td [name="satuannama[]"]').data('currentValue', element.parents(
            'tr').find('td [name="satuannama[]"]').val(item.satuannama))

        setTotalHarga(element)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
        item_id_input.val('');
        element.val('');
      
        let getHargaJual = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="harga[]"]')[0]);
        let getTotalHargaJual = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="totalharga[]"]')[0]);
        let getQtyJual = AutoNumeric.getAutoNumericElement(element.parents('tr').find('td [name="qty[]"]')[0]);
        
        getHargaJual.set(0)
        getTotalHargaJual.set(0)
        getQtyJual.set(0)

        setTotalHargaJual(element)

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
      alignRightMobile: true,
      searching: 1,
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

        let valueSatuan = $(element).val()
        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          valueSatuan.trim() !== "" || //satuan nama
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
          HargaCek !== 0 ||
          TotalHargaCek !== 0;

        if (isRowFilled) {
          currentRow.addClass('filled-row');
        } else {
          currentRow.removeClass('filled-row');
        }
        element.data('currentValue', element.val());
      },
    });
  }

  function checkFilledRowLookup(element){
      let valueItem = $(element).val();
      let currentRow = $(element).closest('tr');
      let qtyJualcek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(
          currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

      let HargaJualCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(
          currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

      let TotalHargaJualCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 :
          parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

      let isRowFilled =
          valueItem.trim() !== "" || //produk nama
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtyJualcek !== 0 ||
          HargaJualCek !== 0 ||
          TotalHargaJualCek !== 0;

      if (isRowFilled) {
          currentRow.addClass('filled-row');
      } else {
          currentRow.removeClass('filled-row');
      }
    }

  var SetDefaultValue;

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}penjualanheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          SetDefaultValue = response.data
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setDefault(form) {
    $.each(SetDefaultValue, (index, value) => {

      let element = form.find(`[name="${index}"]`)
      if (element.is('select')) {
        element.val(value).trigger('change')
      } else {

        element.val(value)
      }

      if (index == 'statusnama') {
        element.val(value)
      }

      if (index == 'statusnama') {
        element.data('current-value', value)
      }
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

  function updateUrut() {
    let elements = $('#detailList tbody tr td.table-bold .label-top');

    elements.each((index, element) => {
      $(element).text(index + 1 + ". produk");
    });
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
    $('.customer-lookup').lookup({
      title: 'customer Lookup',
      fileName: 'customer',
      typeSearch: 'ALL',
      searching: 2,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 2,
          valueName: 'customer_id',
          searchText: 'customer-lookup',
          singleColumn: true,
          hideLabel: true,
          title: 'Customer',
          // typeSearch: 'ALL',
        }
      },
      onSelectRow: (customer, element) => {
        valDiscountPersen = customer.discountpersen
        valDiscountNominal = customer.discountnilai

        $('#crudForm [name=customerid]').first().val(customer.id)
        $('#crudForm [name=alamatpengiriman]').first().val(customer.alamat)

        $('#crudForm [name=top]').first().val(customer.top)
        $('#crudForm [name=topnama]').first().val(customer.toptext)

        element.val(customer.nama)
        element.data('currentValue', element.val())

        let getPersen = AutoNumeric.getAutoNumericElement($('#crudForm [name=discountpersen]')[0]);
        let getNilai = AutoNumeric.getAutoNumericElement($('#crudForm [name=discountnilai]')[0]);
        getPersen.set(customer.discountpersen);
        getNilai.set(customer.discountnilai);

        let discountNilai = $('#crudForm [name=discountnilai]').val().replace(/,/g, '')

        if (discountNilai > 0) {
            isDiscountNominal = true
        }else{
            isDiscountNominal = false
        }

        setSubTotal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())

        let getDiscountPersen = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountpersen"]`)[0]);
        let getDiscountNilai = AutoNumeric.getAutoNumericElement($(`#crudForm [name="discountnilai"]`)[0]);
        
        getDiscountPersen.set(0)
        getDiscountNilai.set(0)
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

    $(`.status-lookup`).lookup({
      title: 'Status Lookup',
      fileName: 'parameter',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS',
          subgrp: 'STATUS',
          searching: 1,
          valueName: `status`,
          searchText: `status-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'status'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=status]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="status"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

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
      url: `${apiUrl}penjualanheader/approvalkacab`,
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
          editPenjualanHeader($('#formApproveKacab').find('[name=id]').val())
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