@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @include('layouts._rangeheader')
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

<!-- Detail -->

@include('pembelianheader._details')
@include('pembelianheader._modal')
@include('pembelianheader._modaleditallpembelian')
@push('scripts')
<script>
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'nobukti'
    let sortorder = 'desc'
    let autoNumericElements = []
    let currentTab = 'detail'
    let selectedRows = [];

    let modalReport = $('#rangeTglModal').find('.modal-body').html()
    let modalBatalPembelian = $('#rangeTglPengiriman').find('.modal-body').html()

    $('#rangeTglModal').on('hidden.bs.modal', () => {
            $('#rangeTglModal').find('.modal-body').html(modalReport)
            initDatepicker('datepickerIndex')
    })

    $('#rangeTglPengiriman').on('hidden.bs.modal', () => {
        $('#rangeTglPengiriman').find('.modal-body').html(modalBatalPembelian)
        initDatepicker('datepickerIndex')
    })



    $(document).ready(function() {


        $("#tabs").tabs()
        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
        loadDetailGrid()

        @isset($request['tgldari'])
        tgldariheader = `{{ $request['tgldari'] }}`;
        @endisset
        @isset($request['tglsampai'])
        tglsampaiheader = `{{ $request['tglsampai'] }}`;
        @endisset


        setRange(true, $.datepicker.formatDate('yy-mm-dd', new Date()))

        initDatepicker('datepickerIndex')

      

        $(document).on('click', '#btnReload', function(event) {
            loadDataHeader('pembelianheader')
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
            selectedRows = []
            $('#gs_').prop('checked', false)
        })

        $(document).on('change', `#formCrud [name="tgldariheader"]`, function() {
            loadDataHeader('pembelianheader')
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
        });

        $(document).on('change', `#formCrud [name="tglsampaiheader"]`, function() {
            loadDataHeader('pembelianheader')
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
        });


        $("#jqGrid").jqGrid({
                url: `${apiUrl}pembelianheader`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val()
                },
                datatype: "json",
                colModel: [{

                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '80px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'Supplier',
                        name: 'suppliernama',
                        align: 'left',
                        width: '180px'
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        align: 'left',
                        width: '170px',

                    },
                    {
                        label: 'tgl bukti',
                        name: 'tglbukti',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },

                    {
                        label: 'Karyawan',
                        name: 'karyawannama',
                        align: 'left',
                        width: '180px'
                    },
                    {
                        label: 'tgl terima',
                        name: 'tglterima',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangan',
                        align: 'left'
                    },
                    {
                        label: 'SUB TOTAL',
                        name: 'subtotal',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'DISCOUNT PERSEN',
                        name: 'discountpersen',
                        align: 'left',
                        formatter: currencyFormatNoDoubleZero,
                        width: '150px'
                    },
                    {
                        label: 'Potongan',
                        name: 'potongan',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'Total',
                        name: 'grandtotal',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'Status',
                        name: 'statusmemo',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusmemo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusmemo'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;

                                    ?>
            `,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let status = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${status.WARNA}; color: #fff;">
                  <span>${status.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {

                            let status = JSON.parse(rowObject.statusmemo)

                            return ` title="${status.MEMO}"`
                        }
                    },

                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby_name',
                        align: 'left'
                    },
                    {
                        label: 'CREATEDAT',
                        name: 'created_at',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATEDAT',
                        name: 'updated_at',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
                // pager : '#pager',
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },
                onSelectRow: function(id) {
                    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'noinvoice')

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) {
                        indexRow = (indexRow - limit * (page - 1))
                    }
                    loadDetailData(id)
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#detailGrid, #historyGrid, #jurnalGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridData($(element))
                        })
                        $('#jqGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridHeader($(element))
                        })
                    }

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    $.each(selectedRows, function(key, value) {

                        $('#jqGrid tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                                $(this).addClass('bg-light-blue')
                            }
                        })

                    });

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                    .click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                    .click()
                            }

                            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                        }
                    }, 100)

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
                    $('#gs_').prop('disabled', false)
                }
            })
            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    abortGridLastRequest($(this))
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })
            .jqGrid('navGrid', '#pager', {
                search: false,
                refresh: false,
                add: false,
                edit: false,
                del: false,
            })

            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: function(event) {
                            createPembelianHeader()
                        }
                    },
                    {
                        id: 'edit',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: function(event) {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasiAksi(selectedId, 'EDIT')
                                // editingAt(selectedId, 'EDIT')
                            }
                        }
                    },
                    {
                        id: 'editall',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT ALL',
                        class: 'btn btn-success btn-sm mr-1 btn-editallpesanancustomer',
                        onClick: function(event) {
                            editAllPembelian()
                        }
                    },
                    {
                        id: 'delete',
                        innerHTML: '<i class="fa fa-trash"></i> DELETE',
                        class: 'btn btn-danger btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasiAksi(selectedId, 'DELETE')
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                viewPembelianHeader(selectedId)
                            }
                        }
                    },
                    // {
                    //     id: 'reportpembelian',
                    //     innerHTML: '<i class="fa fa-print"></i> REPORT PEMBELIAN',
                    //     class: 'btn btn-info btn-sm mr-1',
                    //     onClick: () => {
                    //         $('#formRangeTgl').data('action', 'reportpembelian')
                    //         $('#rangeTglModal').find('button:submit').html(`Report`)
                    //         $('#rangeTglModal').modal('show')
                    //     }
                    // },
                    // {
                    //     id: 'reportpembelianharga',
                    //     innerHTML: '<i class="fa fa-print"></i> REPORT PEMBELIAN 2',
                    //     class: 'btn btn-info btn-sm mr-1 reportpesanan2',
                    //     onClick: () => {
                    //         $('#formRangeTgl').data('action', 'reportpembelianharga')
                    //         $('#rangeTglModal').find('button:submit').html(`Report`)
                    //         $('#rangeTglModal').modal('show')
                    //     }
                    // },
                ],
                extndBtn: [{
                    id: 'report',
                    title: 'Report',
                    caption: 'Report',
                    innerHTML: '<i class="fa fa-print"></i> REPORT',
                    class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
                    dropmenuHTML: [ {
                            id: 'reportpembelian',
                            innerHTML: '<i class="fa fa-print"></i> REPORT PEMBELIAN',
                            class: 'btn btn-info btn-sm mr-1',
                            text: "REPORT PEMBELIAN",
                            onClick: () => {
                                $('#formRangeTgl').data('action', 'reportpembelian')
                                $('#rangeTglModal').find('button:submit').html(`Report`)
                                $('#rangeTglModal').modal('show')
                            }
                        },
                        {
                            id: 'reportpembelianharga',
                            innerHTML: '<i class="fa fa-print"></i> REPORT PEMBELIAN 2',
                            class: 'btn btn-info btn-sm mr-1 reportpembelian2',
                            text: "REPORT PEMBELIAN DENGAN HARGA",
                            onClick: () => {
                                $('#formRangeTgl').data('action', 'reportpembelianharga')
                                $('#rangeTglModal').find('button:submit').html(`Report`)
                                $('#rangeTglModal').modal('show')
                            }
                        },
                    ],
                    }, ]
            })
        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))


        $('#add .ui-pg-div')
            .addClass(`btn btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn btn-sm btn-danger')
            .parent().addClass('px-1')

        function permission() {

            if (!`{{ $myAuth->hasPermission('pembelianheader', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('pembelianheader', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('pembelianheader', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('pembelianheader', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }
        }

        $('#rangeTglModal').on('shown.bs.modal', function() {
            var tglpengiriman = new Date()
            tglpengiriman.setDate(tglpengiriman.getDate())
            $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', tglpengiriman)).trigger('change');
            initLookupMaster()
            initDatepicker()
        })

        $('#formRangeTgl').submit(event => {
            event.preventDefault()
            let params
            let actionUrl = ``
            let submitButton = $(this).find('button:submit')

            /* Clear validation messages */
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            /* Set params value */
            for (var key in postData) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }

            let formRange = $('#formRangeTgl')
            let dari = formRange.find('[name=dari]').val()
            let karyawan = formRange.find('[name=karyawannama]').val()
            params = `&dari=${dari}`;

            if (karyawan) {
                params += `&karyawan=${karyawan}`;
            }

            if ($('#formRangeTgl').data('action') == 'export') {
                let actionUrl = `{{ route('pesananfinalheader.export') }}`

                /* Clear validation messages */
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()
                window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
            } else if ($('#formRangeTgl').data('action') == 'reportpembelian') {
                if (karyawan) {
                    $.ajax({
                        url: `${apiUrl}pembeliandetail/reportpembelian`,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            forReportPb: true,
                            dari: dari,
                            karyawan: karyawan
                        },
                        success: function(response) {
                            // console.log(response)
                            ReportPembelian(response)
                            $('#rangeTglModal').modal('hide')
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#rangeTglModal').modal('hide')
                                setErrorMessages($('#crudForm'), error.responseJSON.errors);
                            } else {
                                showDialog(error.responseJSON.message);
                            }
                        }
                    }).always(() => {
                        $('#processingLoader').addClass('d-none')
                        submitButton.prop('disabled', false)
                    });
                } else {
                    $.ajax({
                            url: `${apiUrl}pembeliandetail/reportpembelian`,
                            method: 'GET',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            data: {
                                forReportPbAll: true,
                                dari: dari,
                            },
                            success: function(response) {
                                // console.log(response)
                                ReportPembelian(response)
                                $('#rangeTglModal').modal('hide')
                            },
                            error: function(error) {
                                if (error.status === 422) {
                                    $('.is-invalid').removeClass('is-invalid');
                                    $('.invalid-feedback').remove();
                                    $('#rangeTglModal').modal('hide')
                                    setErrorMessages($('#crudForm'), error.responseJSON.errors);
                                } else {
                                    showDialog(error.responseJSON.message);
                                }
                            }
                        })
                        .always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        });
                }
            } else if ($('#formRangeTgl').data('action') == 'reportpembelianharga') {
                if (karyawan) {
                    $.ajax({
                        url: `${apiUrl}pembeliandetail/reportpembelian`,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            forReportPb: true,
                            dari: dari,
                            karyawan: karyawan
                        },
                        success: function(response) {
                            ReportPembelianHarga(response)
                            $('#rangeTglModal').modal('hide')
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#rangeTglModal').modal('hide')
                                setErrorMessages($('#crudForm'), error.responseJSON.errors);
                            } else {
                                showDialog(error.responseJSON.message);
                            }
                        }
                    }).always(() => {
                        $('#processingLoader').addClass('d-none')
                        submitButton.prop('disabled', false)
                    });
                } else {
                    $.ajax({
                            url: `${apiUrl}pembeliandetail/reportpembelian`,
                            method: 'GET',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            data: {
                                forReportPbAll: true,
                                dari: dari,
                            },
                            success: function(response) {
                                ReportPembelianHarga(response)
                                $('#rangeTglModal').modal('hide')
                            },
                            error: function(error) {
                                if (error.status === 422) {
                                    $('.is-invalid').removeClass('is-invalid');
                                    $('.invalid-feedback').remove();
                                    $('#rangeTglModal').modal('hide')
                                    setErrorMessages($('#crudForm'), error.responseJSON.errors);
                                } else {
                                    showDialog(error.responseJSON.message);
                                }
                            }
                        })
                        .always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        });
                }
            }
        })

        function ReportPembelianHarga(response) {
            let pembeliandetail = response.data;
            let tglPengiriman = pembeliandetail[0].tglpengiriman;

            Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

            Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

            report = new Stimulsoft.Report.StiReport();
            dataSet = new Stimulsoft.System.Data.DataSet("Data");
            report.loadFile(`{{ asset('public/reports/ReportPembelianHarga.mrt') }}`);
            dataSet.readJson({
                'pembeliandetail': pembeliandetail,
            });

            report.regData(dataSet.dataSetName, '', dataSet);
            report.dictionary.synchronize();

            // var options = new Stimulsoft.Designer.StiDesignerOptions()
            // options.appearance.fullScreenMode = true
            // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
            // designer.report = report;
            // designer.renderHtml('content');

            report.renderAsync(function() {
                report.exportDocumentAsync(function(pdfData) {
                    var fileName = 'LaporanPesanan' + tglPengiriman;
                    Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
                }, Stimulsoft.Report.StiExportFormat.Pdf);
            });
        }

        function ReportPembelian(response) {
            let pembeliandetail = response.data;
            let tglPengiriman = pembeliandetail[0].tglpengiriman;

            Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

            Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

            report = new Stimulsoft.Report.StiReport();
            dataSet = new Stimulsoft.System.Data.DataSet("Data");
            report.loadFile(`{{ asset('public/reports/ReportPembelian.mrt') }}`);
            dataSet.readJson({
                'pembeliandetail': pembeliandetail,
            });

            report.regData(dataSet.dataSetName, '', dataSet);
            report.dictionary.synchronize();

            // var options = new Stimulsoft.Designer.StiDesignerOptions()
            // options.appearance.fullScreenMode = true
            // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
            // designer.report = report;
            // designer.renderHtml('content');

            report.renderAsync(function() {
                report.exportDocumentAsync(function(pdfData) {
                    var fileName = 'LaporanPesanan' + tglPengiriman;
                    Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
                }, Stimulsoft.Report.StiExportFormat.Pdf);
            });
        }

    })
</script>
@endpush()
@endsection