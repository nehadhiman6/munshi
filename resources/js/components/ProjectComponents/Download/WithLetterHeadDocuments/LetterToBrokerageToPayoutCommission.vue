<template>
      <component :is="componentInstance"
        caption="Letter to brokerage to payout commission"
        :file-name="'letter_to_brokerage_to_payout_commission'+file_opening.file_no"
        :content="content"    :client_name="client_name"
        :client_sub_title="client_sub_title"
        :client_address="client_address"
        :client_phone="client_phone"
        :client_email="client_email">
    </component>
</template>

<script>
import {
  AlignmentType,
  Document,
  ImageRun,
  HeadingLevel,
  Packer,
  Paragraph,
  TabStopPosition,
  TabStopType,
  TextRun,
  Table,
  TableRow,
  TableCell,
  PageBreak,
  PageNumber,
  NumberFormat
} from "docx";
export default {
      props:[
        'client_name',
        'client_sub_title',
        'client_address',
        'client_phone',
        'client_email',
        'file_opening_id',
        'file_opening'
    ],
    data:function(){
        return {
            content:''
        }
    },
      computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
    },
   mounted:function(){
        this.getContent();
    },
    methods:{

        getContent:function(){
            var self = this;
            var section = [];

            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name:'';
            var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name:'';
            var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1:'';
            var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2:'';
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            if(self.file_opening.commission.excess_deposit_to_seller == 0) {
                var pay_ref_val = "Please be informed that the subject transaction has closed. A cheque in the amount of $"+Utilities.formatNumber(self.file_opening.commission.commission_payable,2)+" being the balance of the real estate commission due and owing is enclosed.";
                var sellers = "The undersigned trusts you will find the enclosed to be satisfactory."
            } else {
                var pay_ref_val = "This is to confirm that the subject transaction has closed.  Please refund the extra deposit to the sellers as follows:";
                var sellers = '';
                if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                    self.file_opening.sellers.forEach((element,index) => {
                        sellers += (sellers == '') ? '':' and ';
                        sellers += element.name;
                    })
                }
            }

            section.push({

                children:
                [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text: self.file_opening.commission && self.file_opening.commission.brokerage ? self.file_opening.commission.brokerage.name : '',
                                    break:2
                                }),
                                new TextRun({
                                    text: self.file_opening.commission && self.file_opening.commission.brokerage && self.file_opening.commission.brokerage.address ? self.file_opening.commission.brokerage.address.addr_line1 : '',
                                    break:1
                                }),
                                new TextRun({
                                    text: self.file_opening.commission && self.file_opening.commission.brokerage && self.file_opening.commission.brokerage.address ? self.file_opening.commission.brokerage.address.addr_line2 : '',
                                    break:1
                                }),
                                new TextRun({
                                    text: "Attention: "+ (self.file_opening.real_estate_agent ? self.file_opening.real_estate_agent.name:''),
                                    break:2,
                                    underline:true
                                }),
                                new TextRun({
                                    text: "Dear Sir or Madam:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),

                                new TextRun({
                                    text: '\t '+seller1+' to '+purchaser1,
                                }),
                                new TextRun({
                                    text: '\t '+firm_addr1+' '+firm_addr2,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date:' + '\t ' + closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t My File No:' + '\t ' +self.file_opening.file_no,
                                    break:1
                                }),

                            ],
                            border: {
                                bottom: {
                                    color: "auto",
                                    space: 5,
                                    value: "single",
                                    size: 7,
                                },
                            },
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: pay_ref_val,
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: sellers,
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),




                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "Yours very truly,",
                                break:2
                            }),

                            new TextRun({
                                text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name:'',
                                break:3
                            }),

                            new TextRun({
                                text: acronym,
                                break:2
                            }),
                        ],
                    }),


                ],
            });
            console.log(section);
            self.content = section;
        }
    }

}
</script>

<style>

</style>
