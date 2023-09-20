<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Search RESULTS</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="card-title">
                                <b>Munshi Account No. {{ ac_no }}</b>
                            </div>
                            <div class="iw-btn-area">
                                <button class="btn btn-sm btn-primary">Print Invoice</button>
                                <button class="btn btn-sm btn-secondary">Download Invoice</button>
                            </div>
                        </div>
                        <form class="form-inline" action="">
                            <label for="" class="mr-sm-2">Total files opened: </label>
                            <input type="text" v-model="files_qty" class="form-control mb-2 mr-sm-2" placeholder="" id="">
                            <label for="" class="mr-sm-2">Total charges incurred :</label>
                            <input type="text"  v-model="amount" class="form-control mb-2 mr-sm-2" placeholder="" id="">
                        </form>
                        <div class="iw-table-area">
                            <table id="dt-fee-report" class="table table-theme table-bordered" width="100%" >
                                <!-- <tfoot>
                                    <tr>
                                        <td colspan="4">Total</td>
                                        <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">HST</td>
                                         <td>$0.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total Paid</td>
                                         <td>$0.00</td>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['filter_form'],
    data:function(){
        return {
            createUrl:"file-fee-report",
            amount: '',
            files_qty: '',
            ac_no: Munshi.ac_no,
            table: null
        }
    },
    mounted:function(){
        this.setTable();
    },
    methods: {
        setTable() {
            var self = this;
            var target = 0;
            self.table = $("#dt-fee-report").DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'excelHtml5',
                    header: true,
                    // footer: true,
                    exportOptions: {
                        orthogonal: 'export'
                    },

                },
                // 'excelHtml5',
                // 'pdfHtml5',
            ],
            serverSide: true,
            ordering: true,
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            order: [[ 1, "desc" ]],
            ajax: {
                url: self.createUrl,
                type: "POST",
                data: function (param) {
                    param.from_date = self.filter_form.from_date;
                    param.to_date = self.filter_form.to_date;
                    param.month = self.filter_form.month;
                },
                dataSrc: function(json) {
                    self.amount = json.files.amount;
                    self.files_qty = json.files.files_qty;
                    return json.data;
                }
            },
            scrollX: true,
            columnDefs: [
                {
                    title: "Date File Opened",
                    targets: target++,
                    orderable: false,
                    data: "date",
                    render: function (data, type, row, meta) {
                        return moment(data,'YYYY-MM-DD').format('MM-DD-YYYY');
                        var index = meta.row + parseInt(meta.settings.json.start);
                    },
                },
                {
                    title: "Lawyer File No.",
                    targets: target++,
                    data: "file_no",
                    className: "text-title",
                },
                {
                    title: "Description",
                    targets: target++,
                    data: "client_name",
                    className: "text-title",
                },
                {
                    title: "Munshi Ref",
                    targets: target++,
                    data: "ref",
                    className: "text-title",
                },

                {
                    title: "Munshi Fee",
                    targets: target++,
                    data: "rate",
                    className: "text-title",
                },
            ],
        });
        },


        reloadTable: function () {
            var self = this;
            self.table.ajax.reload();
        },




    }
}
</script>
