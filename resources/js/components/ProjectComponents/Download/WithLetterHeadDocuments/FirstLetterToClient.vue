<template>
 <component :is="componentInstance"
        caption="First letter to client"
        :file-name="'first_letter_to_client_'+file_opening.file_no"
        :content="content"
        :client_name="client_name"
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
import DocumentGeneratorLetterHead from '../DocumentGeneratorLetterHead.vue'
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
    mounted:function(){
        this.getContent();
    },
    computed: {
        componentInstance () {
            const name = lh_no;
            return () => import(`../${name}`)
        }
    },
    methods:{

        getContent:function(){
            var self = this;

            var section = [];
            var current_date = moment().format('LL');
            var closing_date  = self.file_opening.closing_date ? moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL"):"";
            var sellers= '';
            var seller_addr = '';
            if(self.file_opening.sellers && self.file_opening.sellers.length > 0){
                self.file_opening.sellers.forEach((element, index) => {
                    sellers += (sellers == '') ? '':' and ';
                    sellers += element.first_name ? element.first_name + ' ' :'';
                    sellers += element.middle_name ? element.middle_name +' ' :'';
                    sellers += element.last_name ? element.last_name+' ' :'' ;
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
                                    break:2
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
                        alignment:AlignmentType.CENTER,
                        children: [
                                new TextRun({
                                    text: "MEMO TO CLIENT(S) RE: SALE",
                                    bold:true,
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
                                    text: "This is to confirm that we are in receipt of a copy of the Agreement of Purchase and Sale and that it is our pleasure to act on your behalf. Further to our previous conversation by phone, this is to confirm that my office will issue you a Statement of Account for the services provided by my office once my fees and disbursements for this transaction are paid in full at the time of closing.",
                                    break:1

                                }),
                                new TextRun({
                                    text: "The fees to be charged by our office for your transcation will be as follows:",
                                    break:1,
                                }),
                                new TextRun({
                                    text: "\t\t\t Closing Fee re Sale: ",
                                    break:2,
                                }),
                                new TextRun({
                                    text: "\t $0.00 ",
                                }),
                                new TextRun({
                                    text: "\t\t\t TOTAL FEES: ",
                                    break:1,
                                }),
                                new TextRun({
                                    text: "\t\t $0.00 ",
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
                                    text: "These fees are based on the presumption that the transaction is without any complexities or requests for extension of the closing date. The undersigned reserves the right to charge additional fees for any additional time spent in addressing unusual difficulties arising during the processing of the transaction that are beyond the control of our office. Further, the above fees do not reflect any disbursements that have to paid on your behalf during the processing of the transaction.",

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
                                    text: "1. \tDOCUMENTS ",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "Please also forward the following to the undersigned at your earliest:",
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
                                    text: "A copy of your Transfer/Deed of Land.",
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
                                    text: "Name and mortgage number of any existing Charge/Mortgage",
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
                                    text: "Current realty tax bill.",
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
                                    text: "Survey",
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
                                    text: "Your forwarding address (if the undersigned is not acting on the purchase of your new home).",
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
                                    text: "Hot Water Rental company name and contact information to request an assumption agreement as the purchaser(s) would be assuming this rental equipment.",
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
                                    text: "Amount of rents and confirmation of any deposit received, if the subject property is rented.",
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
                                    text: "Please have available information retlated to keys, fobs, security system or any cod in case of a condominium.",
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
                                    text: "2. \tMARITAL/RESIDENCY STATUS",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "Our office would require the marital and residency status of all persons on title. If any of the persons on the title is married and his or her spouse is not on the title, and house is a matrimonial house, it is very important that his or her spouse is also attends for signing.",
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
                                    text: "3. \tFIRE INSURANCE",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "Unless the property is a condominium or vacant land, kindly do NOT cancel your fire insurance policy on the property until we notify you of closing of the transaction. ",
                                    break:2

                                }),
                                new TextRun({
                                    text: "FURTHER, IT WILL YOUR RESPONSIBILITY TO CANCEL THE FIRE INSURANCE POLICY.",
                                    bold:true,
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
                                    text: "4. \tUTILITY COMPANIES",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "Our office would be contacting all the utilities for transferring the accounts into new purchase’s name. However, these department require owners to contact as well.",
                                    break:2

                                }),
                                new TextRun({
                                    text: "We will provide you the contact information of all utility departments in a separate letter.",
                                    break:1

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
                                    text: "5. \tREAL ESTATE COMMISSION",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "In case the property is sold through a real estate office, please provide our office with the Listing Agreement (Authority to Sale or Lease) ASAP so that the real estate commission, to be charged as per the Commission Statement provided by the Broker in accordance with the Listing Agreement on the sale, could be calculated upfront.",
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
                                    text: "6. \tAPPOINTMENT TO SIGN CLOSING DOCUMENTS ",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "Prior to the closing, our office will contact you to set up a time for signing the closing documents. During that appointment, you will also be advised about the various documents involved in the transaction - the Statement of Adjustments, Mortgage Discharge Statements, Commission Statement and any other requisite documents.",
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
                                    text: "7. \tIDENTITY VERIFICATION",
                                    bold:true,
                                }),
                                new TextRun({
                                    text: "It is your responsibility to provide our office with documents that identify you. We need proof of your name, telephone number, contact address, occupation, email IDs and will need to verify these from two pieces of identification in a reasonable time-frame prior to closing. Please make sure all the ID documents must be current.",
                                    break:2

                                }),
                                new TextRun({
                                    text: "Below are two lists of documents. We would need at least ONE piece of ID from List A that must have a photograph on it. The other document can be provided from list B.",
                                    break:1
                                }),
                                new TextRun({
                                text: "List A",
                                bold:true,
                                break:2
                            }),
                                // new PageBreak()
                            ],
                            spacing: {
                                before:200
                            },
                    }),
                    new Paragraph({
                        text: "Passport",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Permanent Resident Card",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Record of Landing",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Citizenship Card",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Provincial Driver's License",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Old Age Security Card; and",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Police/Military ID.",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "List B",
                                bold:true,
                                break:2
                            }),
                            ],
                    }),

                    new Paragraph({
                        text: "Canadian Birth Certificate",
                        bullet: {
                            level: 0
                        }
                    }),

                    new Paragraph({
                        text: "Employment ID Card with photograph",
                        bullet: {
                            level: 0
                        }
                    }),

                    new Paragraph({
                        text: "A credit card with signature",
                        bullet: {
                            level: 0
                        }
                    }),

                    new Paragraph({
                        text: "Social Insurance Number",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "In case the seller is a Corporation, the following information is required before closing:",
                                break:1
                            }),
                        ],
                    }),
                    new Paragraph({
                        text: "Company’s full name, business phone number, type of business or activity;",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Official authorized to direct, that official’s position in the company and phone number;",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Minutes book",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Articles of Incorporation",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "GST number",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Certificate of Corporate Status",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Annual filings of the organization (please specify the type of filing)",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Partnership agreement (in case of a partnership); and",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        text: "Trust Agreement (in case of a Trust).",
                        bullet: {
                            level: 0
                        }
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "8. \tCONDOMINIUM MONTHLY PAYMENT",
                                bold:true,
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "In case of sale of a condominium, you shall advise the condominium corporation or the management company upfront about your closing date. ",
                                break:1
                            }),
                            new TextRun({
                                text: "It is your responsibility to cancel the condominium’s monthly payments.",
                                bold:true
                            }),
                        ],
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "9. \tCONSENT TO ACT RE CONFLICT:",
                                bold:true,
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "This letter also confirms that our office will be acting for all/both of you for this transaction. You acknowledge that we have advised you that information received in relation to this transaction from either party cannot be treated as confidential insofar as the other party is concerned. Also, that you have been advised that as per rules of the Law Society of Ontario, when law firms act for more than one party, this fact should be revealed to the other party, with a recommendation to the other party to obtain independent representation or independent legal advice.",
                                break:1
                            }),
                            new TextRun({
                                text: "You further acknowledge that you have been advised that in case there is a conflict at any stage of the transaction that cannot be resolved, the undersigned cannot continue to act for all/both of you, and may have to entirely withdraw from the transaction.",
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "10. \tCOMMUNICATIONS",
                                bold:true,
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "We request that you confirm a  preferred method of communication. To maintain confidentaility, our email communucation is between you and us only. If you include any thrid party to the email, we will not be liable for the breach of confidentiality.",
                                break:1
                            }),
                        ],
                    }),

                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "11. \tGENERAL",
                                bold:true,
                                break:2
                            }),
                        ],
                    }),
                    new Paragraph({
                        children: [
                                new TextRun({
                                text: "It is requisite that you provide us with all the information as requested in this letter, so that we can have all the documents prepared reasonably ahead of the closing date.",
                                break:1
                            }),
                            new TextRun({
                                text: "A lawyer’s responsibility is limited to preparing documentation for the sale of the property in issue. We shall not be responsible for any damages or claims if the Agreement of Purchase and Sale is not completed in a timely fashion.",
                                break:2
                            }),
                            new TextRun({
                                text: "We cannot guarantee that the transaction can be closed at a specific time. However, we do advise you to vacate the property on time on the day of closing. Similarly, we cannot guarantee an exact closing time. However, as per the Agreement of Purchase and Sale, the agreement must be completed by 6pm on the day of closing.",
                                bold:true,
                                break:2
                            }),
                            new TextRun({
                                text: "We understand that this transaction is a important to you. We are here to assist you and answer any questions you may have.",
                                break:2
                            }),

                            new TextRun({
                                text: "Please note that you can contact us by telephone, fax, and email. If there is anything you do not understand, please contact myself or one of my legal assistants will be able to provide you with the information you may require.",
                                break:2
                            }),

                            new TextRun({
                                text: "Thanks for this opportunity of serving you!",
                                break:2
                            }),

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
            self.content = section;
        }
    }
}
</script>

<style>

</style>
