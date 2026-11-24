@extends('layouts.master')

@section('content')

<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">Periode<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="tgldariheader" id="tgldariheader" class="form-control datepickerIndex">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">S/D<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="tglsampaiheader" id="tglsampaiheader" class="form-control datepickerIndex">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnSave" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

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
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false

    $(document).ready(function() {
        initDatepicker('datepickerIndex')
    })

    $(document).on('click', `#btnSave`, function(event) {

        let tgldari = $('#crudForm').find('[name=tgldariheader]').val()
        let tglsampai = $('#crudForm').find('[name=tglsampaiheader]').val()

        // console.log(tgldari, tglsampai)

        getRekalkulasiHppStok().then((response) => {
            showSuccessDialog(`HPP dan STOK dari tanggal ${tgldari} sampai tanggal ${tglsampai} berhasil direkalkulasi.`);
        }).catch((error) => {
            if (error.status === 422) {
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove()

                setErrorMessages($('#crudForm'), error.responseJSON.errors);
            } else {
                showDialog(error.statusText, error.responseJSON.message)
            }
        })
    })

    function getRekalkulasiHppStok() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}hpp/rekalkulasi`,
                method: 'POST',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    tgldari: $('#crudForm').find('[name=tgldariheader]').val(),
                    tglsampai: $('#crudForm').find('[name=tglsampaiheader]').val(),
                    isCheck: true,
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)
                },
            });
        });
    }
</script>
@endpush()

@endsection