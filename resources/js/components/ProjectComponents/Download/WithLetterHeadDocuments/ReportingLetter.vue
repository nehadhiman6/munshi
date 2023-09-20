<template>
       <component :is="componentInstance"
        :file-name="'reporting_letter_'+file_opening.file_no"
        caption="Reporting Letter"
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
      computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
    },
    data:function(){
        return {
            content:''
        }
    },
      mounted:function(){
        this.getImageContent();
    },
    methods:{
         getImageContent:function(){
            var self = this;
            const getBase64FromUrl = async (url) => {
            const data = await fetch(url);
            const blob = await data.blob();
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = () => {

                const base64data = reader.result;
                 resolve(base64data);
                }
            });
            }


            var image_url ='';
            getBase64FromUrl('https://lh3.googleusercontent.com/i7cTyGnCwLIJhT1t2YpLW-zHt8ZKalgQiqfrYnZQl975-ygD_0mOXaYZMzekfKW_ydHRutDbNzeqpWoLkFR4Yx2Z2bgNj2XskKJrfw8').then(function(url){
              console.log(url);
              self.getContent(url.replace(/^data:image\/(png|jpg);base64,/, ""));
            })

        },
        getContent:function(image_url){
            var self = this;
            var section = [];
            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ?moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";

            var seller1= '';
            var sellers= '';
            var seller_addr = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element, index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.name;
                    if(index == 0) {
                        seller1 = element.name;
                    }
                    if(index == self.file_opening.sellers.length-1) {
                        seller_addr += (element.is_current_address_subject_property == 'N' && element.current_address) ? (element.current_address.addr_line1+' '+element.current_address.addr_line2).trim():'';
                    }
                })
            }
            var to = "";
            var purchasers = self.file_opening.purchasers ? self.file_opening.purchasers:[];
            purchasers.forEach((element, index) => {
                if (element.salutation == "Corporation") {
                    to += element.company_name + " ";
                } else {
                    to += element.first_name ? element.first_name + " " : " ";
                    to += element.middle_name ? element.middle_name + " " : "";
                    to += element.last_name ? element.last_name + " " : "";
                }
                if (
                    index < purchasers.length - 1 &&
                    index != purchasers.length - 2
                ) {
                    to += ",";
                } else if (index == purchasers.length - 2) {
                    to += " and ";
                }
                to += " ";
            });

            var property = self.file_opening.property;
            console.log(property);
            if (property) {
                var re = "";
                re += property.street_no ? property.street_no + ", " : "";
                re += property.street_name ? property.street_name + ", " : "";
                re += property.unit_no ? property.unit_no + ", " : " ";
                re += property.city ? property.city.city_name + ", " : "";
                re += property.province ? property.province + ", " : "";
                re += property.postal_code ? property.postal_code : "";
            }

            var str = self.client_name;
            var matches = str.match(/\b(\w)/g); // ['L','G']
            var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials:'';
            section.push({

                children: [
                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: current_date,
                                    break:2
                                }),
                                new TextRun({
                                    text:  sellers+' '+seller_addr,
                                    break:2
                                }),
                                new TextRun({
                                    text: property.addr_line1,
                                    break:1
                                }),
                                new TextRun({
                                    text: property.addr_line2,
                                    break:1
                                }),
                                new TextRun({
                                    text: "Dear Mr. and Mrs.:",
                                    break:4
                                }),
                                new TextRun({
                                    text: "RE:",
                                    break:2
                                }),
                                new TextRun({
                                    text: "\t "+sellers+" (the 'Vendor') s/t "+to + "(the \"Purchaser\")",
                                }),
                                new TextRun({
                                    text: "\t "+property.addr_line1+', '+property.addr_line2 +" (the \"Property\")",
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Closing Date:' + '\t ' + closing_date,
                                    break:1
                                }),
                                new TextRun({
                                    text: '\t Our File No:' + '\t ' +self.file_opening.file_no,
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
                                    text: "I am pleased to now submit my reporting letter in relation to your sale of the above property",
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
                                    text: "Your Sale Transaction",
                                    bold:true,
                                    underline:true
                                }),
                                new TextRun({
                                    text: 'As per terms of the Agreement of Purchase and Sale dated ____________, along with any and all addendums and amendments thereto (hereinafter collectively referred to as the "Purchase Agreement"), the above-mentioned transaction was completed on ///////////August 27th, 2021.',
                                    break:2
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
                                    text: "Transfer of Title",
                                    bold:true,
                                    underline:true
                                }),
                                new TextRun({
                                    text: "As per directions received from the Purchaser, title has been transferred to "+to+" following the execution of an “Acknowledgement and Direction” by the Vendor, that authorized the undersigned to execute and release the transfer on behalf of "+sellers+".",
                                    break:2
                                }),
                                new TextRun({
                                    text: 'On /////////////August 27th, 2021, the transfer was registered as Instrument No.  _________. ',
                                    break:2
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
                                    text: "Statement of Adjustments",
                                    bold:true,
                                    underline:true
                                }),
                                new TextRun({
                                    text: 'As of the closing date, all adjustments set out on the Statement of Adjustments (as reviewed and approved by you) have been made. The statement sets out that:',
                                    break:2
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
                                    text: "Statement of Adjustments",
                                    bold:true,
                                    underline:true
                                }),
                                new TextRun({
                                    text: 'As of the closing date, all adjustments set out on the Statement of Adjustments (as reviewed and approved by you) have been made. The statement sets out that:',
                                    break:2
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),
                    new Paragraph({
                        text: "The property had a purchase price of ________________.",
                        bullet: {
                            level: 0
                        },
                        spacing: {
                                after: 200,
                                before:200
                            },
                    }),
                    new Paragraph({
                        text: "A deposit(s) in the amount of ________________ was/were made to the Purchaser.",
                        bullet: {
                            level: 0
                        },
                        spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        text: "REALTY TAXES - For the purpose of adjustments, the 2021 taxes were estimated to be ____________, based on a 5.0% increase over the 2020 tax bill of ____________.  Since your prorated share of the taxes, for the period from January 1, 2021 to February 10, 2021 amounted to ____________ whereas you had paid nothing on this account, the purchaser received credit in the Statement of Adjustments with the sum of ____________.",
                        bullet: {
                            level: 0
                        },
                        spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        text: "COMMON EXPENSES - The monthly common expenses for the unit, in the amount of ____________, were paid by you for February, 2021.  Since your share of the common expenses for the 9 days of the month that you owned the property amounted to ____________, you received credit in the Statement of Adjustments with the sum of ____________.",
                        bullet: {
                            level: 0
                        },
                        spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        text: "Since the final meter readings were yet to be conducted on closing by the appropriate utilities and final bills were still to be issued to the Vendor, adjustments were not made for hydro, gas, and water.",
                        bullet: {
                            level: 0
                        },

                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        text: "The balance due on closing was ____________.",
                        bullet: {
                            level: 0
                        },

                            spacing: {
                                after: 200,
                                before:200
                            },
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Please review the enclosed Statement of Adjustments for any additional items and corresponding amounts that were adjusted on the closing of your transaction.",
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
                                    text: "Property Insurance",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "Following your advice that you had notified your agent to cancel coverage for the subject Property effective at 12:01 a.m. on the day after the closing date, your policy of insurance was not transferred to the Purchaser on closing.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Please make sure that appropriate arrangements have been made for any other property insurance you may require.",
                                    break:2
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
                                    text: "Reporting Sale of Principal Residence to Tax Authorities",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "Beginning with the taxation year 2016, individuals selling their principal residence are required to report the sale on their income tax return. There are tax exemptions associated with the sale of principal residence. Please contact qualified accounting professionals for further information.",
                                    break:2
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
                                    text: "Real Estate Commission",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "The commission payable to the real estate office upon the sale of the Property was ____________. A Purchaser’s deposit of ____________ had already been given to the real estate broker. Thus, the balance owing is ____________. A cheque in this amount has been sent over to the real estate brokerage, as indicate in the Statement of Receipts and Disbursements.",
                                    break:2
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
                                    text: "Existing Charge Information",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "Instrument No. _________ is a Charge/Mortgage of Land to and in favor of The Toronto-Dominion Bank, in the amount of __________, that needed to be discharged for this mortgage.",
                                    break:2
                                }),
                                new TextRun({
                                    text: "From the funds which we received from the purchasers on the closing of this transaction, I forwarded the sum of ____________ so as to discharge the previous first mortgage in favour of 12345 Financial Corporation Inc..",
                                    break:1
                                }),
                                new TextRun({
                                    text: "I will be obtaining and registering a discharge of this mortgage as soon as possible after closing",
                                    break:2
                                }),
                                new TextRun({
                                    text: "Please find enclosed a copy of the discharge statement that was reviewed with you prior to the closing.",
                                    break:2
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
                                    text: "*TRANSFER OF FUNDS",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "As per your instruction, (Names of sellers), hereby authorizes to use your sale proceeds of property address here, (scheduled to close on February 10, 2021 sale file no. 13-207) towards the purchase of (Purchase property address here ), schedule to close on January 25, 2019, purchase file no. 11-000.",
                                    break:2
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
                                    text: "*INDEPENDENT LEGAL ADVICE",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "Mr. / Mrs. (name of the spouse not on title) received Independent Legal Advice from (Mr. Name of the lawyer), Barrister & Solicitor before signing the Transfer documents for the above mentioned transaction ( a copy is enclosed for your perusal).",
                                    break:2
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
                                    text: "*DELAY CLOSING",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "As per the Agreement of Purchase and Sale your closing date was January 25, 2021, but as the purchaser did not provide us with funds on time to close this transaction and as per your instructions and agreement to give extension,  it was delayed and closed on February 10, 2021.",
                                    break:2
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
                                    text: "*BRIDGE FINANCING",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "From the funds which we received from the purchasers on the closing of this transaction, I forwarded the sum of ________ to pay off a bridge financing which was received from (NAME OF the BANK) to complete your purchase transaction of (address of purchase property here), on January 25, 2021, in the amount of ____________.",
                                    break:2
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
                                    text: "*SPOUSAL CONSENT",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "Mr. (Name of spouse not on title) spouse of Mrs. (name of spouse one title) has signed spousal consent for this mortgage in our office on January 22, 2021.",
                                    break:2
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
                                    text: "*OUTSTANDING PROPERTY TAXES",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "From the funds which we received from the purchasers on the closing of this transaction, I forwarded the sum of _______ to the City of Brampton, being the outstanding property tax amount for 2021.",
                                    break:2
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
                                    text: "*SURVIVORSHIP APPLICATE",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "The title of the property you are selling was in your " +seller1+ " and your late Late spouse (name of spouse) as Joint tenants. Pursuant to the land Titles Act, we registered a survivorship application to trasnfer the title in your name. You signed the Application and afiidavit at our office on _________, 2021.",
                                    break:2
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
                                    text: "*WRIT OF EXECUTIONS:",
                                    bold:true,
                                    underline:true,
                                }),
                                new TextRun({
                                    text: "On our execution search 1 writ appeared against  the similar name of ("+seller1+"). You singed the statutory declaration confirming  ("+seller1+") is not the same person (s) as in the writs. OR",
                                    break:2
                                }),
                                new TextRun({
                                    text: "We received a  clearance certificate/ release from judgment creditor from the said  write affecting the parcel.",
                                    break:2
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
                                    text: "Enclosures:",
                                    bold:true,
                                    underline:true,
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
                                    text: "Statement of Account",
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Trust ledger",
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Statement of Receipts and Disbursements",
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Statement of Adjustment",
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Mortgage Statement for Discharge Purposes",
                                }),

                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Real Estate Brokerage's Commission Statement",
                                }),
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Vendor's Undertaking, Warranty, Direction and Declaration",
                                }),
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Purchaser's Undertaking to Readjust",
                                }),
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                    text: "Declaration for HST",
                                }),
                            ],
                            spacing: {
                                after: 200,
                                before:200
                            },
                            numbering: {
                                reference: "my-custom-numbering",
                                level: 1
                            }
                    }),




                    new Paragraph({
                        children: [

                            new TextRun({
                                text: "Thank you for your retainer to represent you with respect to this transaction. If you require further assistance in future, or if you should have any questions with respect to the above matter, please contact us at your convenience.",
                            }),
                            new PageBreak(),

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
                            new TextRun({
                                text: "Encl.",
                                break:2
                            }),
                            new TextRun({
                                text: "* All paragraph with this sign are added as generic, we can remove which ever is not applicable in a particular file.",
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
