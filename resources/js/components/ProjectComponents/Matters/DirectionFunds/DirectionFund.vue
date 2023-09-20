<template>

        <div class="form-horizontal">
            <div class="card-body">
                <table class="table">
                    <!-- <thead>
                        <tr>
                        <th scope="col">Particulars</th>
                        <th scope="col" width="220">Receivable</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <td>{{sellers_lawyer}}, in trust</td>
                            <td></td>
                            <td> $ {{receive_purchase_closing_show}}</td>
                        </tr>
                      <tr v-for="mort in mortgages" :key="mort.id">
                            <td>{{mort.mortgagee.company_name}}</td>
                            <td>$ {{mort.principal_amount}}</td>
                            <td></td>
                        </tr>
                          <tr>
                            <td>{{name_of_brokerage}}</td>
                            <td>$ {{paid_real_estate_commission}}</td>
                            <td></td>
                        </tr>
                         <tr>
                            <td>{{sellers_names}}</td>
                            <td>$ 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td>$ 0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th> Produce Document</th>
                        </tr>
                        <tr>
                            <td>{{sellers_names}}</td>
                            <td>$ 0</td>
                            <td></td>
                        </tr>
                        <tr v-for="mort in mortgages" :key="'doc'+mort.id">
                            <td>{{mort.mortgagee.company_name}}</td>
                            <td>$ {{mort.principal_amount}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Real Estate Commission owing ({{real_estate_broker}})</td>
                            <td>$ 0</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

</template>

<script>


function getNewTransaction(file_opening_id){
    return{
        id:0,
        file_opening_id:file_opening_id,
        particulars:'',
        type:'',
        amount:'',
        random:Utilities.getRandomNumber()
    }

}

export default
{
    props:['file_opening_id','form','permissions'],
    data:function(){
        return {
            create_url:'trust-ledgers',
            base_url:Munshi.base_url,
            credit_types:[],
            show:true,
            paid_real_estate_commission:0,
            name_of_brokerage:'',
            mortgages:[],
            sellers_lawyer:'',
            sellers_names:'',
            real_estate_broker:'',
               receive_purchase_closing:0,
        }
    },
    computed:{
          receive_purchase_closing_show() {
            return Math.abs(this.receive_purchase_closing);
        },
        total:function(){
            // var net = Utilities.round(this.receive_purchase_closing);
            // net-= Utilities.round(this.discharge_existing_mortgage);
            // net-= Utilities.round(this.paid_real_estate_commission);
            // net-= Utilities.round(this.total_fees_disbursement);
            // net-= Utilities.round(this.paid_hst);

            // this.form.trust_ledgers.forEach(function(ele){
            //     if(ele.type == 'receivable')
            //     {
            //         net+= Utilities.round(ele.amount);
            //     }
            //     else if(ele.type == 'payable')
            //     {
            //         net-= Utilities.round(ele.amount);
            //     }
            // });

            // return Utilities.round(net);
        }

    },
    mounted:function(){
        this.show = true;
        this.form.file_opening_id = this.file_opening_id;
        this.DirectionFund();
    },
    methods:{
        DirectionFund:function(){
            var self = this;
            axios.get(this.base_url+'/file-page/'+this.file_opening_id)
            .then(function(response){
                if(response.data.success){
                    var trust_ledgers = response.data.file_opening.trust_ledgers;
                    var file_opening = response.data.file_opening;
                    self.form.file_opening_id = self.file_opening_id;
                    self.name_of_brokerage =  file_opening.commission ? file_opening.commission.brokerage ? file_opening.commission.brokerage.name :'':'';
                    self.paid_real_estate_commission =  file_opening.commission ? file_opening.commission.commission_payable:0;
                    self.mortgage_name = '';
                    self.mortgage_amount = '';
                    self.mortgages = file_opening.mortgages;
                    self.receive_purchase_closing = file_opening.statement_adjustment ? file_opening.statement_adjustment.balance_due : 0;
                    // if(file_opening.mortgages.length > 0){
                    //     self.mortgage_amount = file_opening.mortgages[0] ?  file_opening.mortgages[0].total_mortgage_payable_discharge:0;
                    //     var name = '';
                    //     if(file_opening.mortgages[0].mortgagee){
                    //          if(file_opening.mortgages[0].company_name){
                    //             name = file_opening.mortgages[0].company_name ? file_opening.mortgages[0].company_name + ' ':'';
                    //         }
                    //         else{
                    //             name += file_opening.mortgages[0].mortgagee.first_name ? file_opening.mortgages[0].mortgagee.first_name : ' ';
                    //             name += file_opening.mortgages[0].mortgagee.middle_name ? ' ' +file_opening.mortgages[0].mortgagee.middle_name : ' ';
                    //             name += file_opening.mortgages[0].mortgagee.last_name ? ' '+file_opening.mortgages[0].mortgagee.last_name : ' ';
                    //         }

                    //     }
                    //     self.mortgage_name = name;
                    // }

                    if(file_opening.solicitor){
                        self.sellers_lawyer = '';
                        self.sellers_lawyer +=file_opening.solicitor.first_name ?file_opening.solicitor.first_name + ' ' :' ';
                        self.sellers_lawyer +=file_opening.solicitor.middle_name ?file_opening.solicitor.middle_name +' ' :'';
                        self.sellers_lawyer +=file_opening.solicitor.last_name ?file_opening.solicitor.last_name+' ' :'' ;

                    }

                     var sellers = response.data.file_opening.sellers;
                     sellers.forEach((element,index) => {
                        if(element.salutation == 'Corporation'){

                            self.sellers_names += element.company_name  ? element.company_name + ' ':'';
                        }
                        else{
                            self.sellers_names += element.first_name ? element.first_name + ' ' :' ';
                            self.sellers_names += element.middle_name ? element.middle_name +' ' :'';
                            self.sellers_names += element.last_name ? element.last_name+' ' :'' ;
                        }
                        if(index < sellers.length-1){
                            self.sellers_names += ',' ;
                        }
                        self.sellers_names += ' ' ;

                    });


                    var mortgages = response.data.file_opening.mortgages;

                    // mortgages.forEach((element,index) => {
                    //     if(element.mortgagee){
                    //         if(element.mortgagee.company_name){
                    //               self.mortgages_names += element.mortgagee.company_name ? element.mortgagee.company_name + ' ':'';
                    //         }
                    //         else{
                    //             self.mortgages_names += element.mortgagee.first_name ? element.mortgagee.first_name + ' ':'';
                    //             self.mortgages_names += element.mortgagee.middle_name ? element.mortgagee.middle_name + ' ':'';
                    //             self.mortgages_names += element.mortgagee.last_name ? element.mortgagee.last_name + ' ':'';
                    //         }
                    //     }
                    //     if(index < mortgages.length-1)
                    //         self.mortgages_names += ', ';
                    // });


                    var commission = response.data.file_opening.commission;
                    if(commission && commission.brokerage)
                    {
                        console.log(commission);
                        self.real_estate_broker =commission.brokerage.name;
                    }

                }
            })
            .catch(function(error){
                console.log("error");
                console.log(error);
            });
        }
    }
}
</script>
