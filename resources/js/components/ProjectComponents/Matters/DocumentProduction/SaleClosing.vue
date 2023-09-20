<template>
    <tr>
        <td>
            <div class="custom-control custom-checkbox">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customCheck1"
                />
                <label class="custom-control-label" for="customCheck1"></label>
            </div>
        </td>
        <td>Sale Closing</td>
        <td>Undertaking file</td>
        <td>
            <document-generator
                :key="1"
                caption="sale_closing.docx"
                :fileName="'sale_closing_' + file_opening.file_no"
                :creator="author"
                :content="undertaking_content"
            >
            </document-generator>
        </td>
    </tr>
</template>

<script>
import {
    AlignmentType,
    Document,
    HeadingLevel,
    Packer,
    Paragraph,
    TabStopPosition,
    TabStopType,
    TextRun,
    Table,
    TableRow,
    TableCell
} from "docx";
import DocumentGenerator from "../../GlobalComponents/DocumentGenerator.vue";

export default {
    components: { DocumentGenerator },
    props: ["file_opening", "author"],
    data() {
        return {
            undertaking_content: null
        };
    },
    mounted() {
        this.setContentData();
    },
    methods: {
        currentMonth: function() {
            const date = new Date(); // 2009-11-10
            const month = date.toLocaleString("default", { month: "long" });
            return month;
        },

        currentYear: function() {
            const date = new Date(); // 2009-11-10
            const year = date.getFullYear();
            return year;
        },

        setContentData: function() {
            var self = this;
            var content = [];
            var section1 = [];

            var purchasers = self.file_opening.purchasers;
            var to = "";
            var purchaser1 = "";
            purchasers.forEach((element, index) => {
                if (element.salutation == "Corporation") {
                    to += element.company_name + " ";
                } else {
                    to += element.first_name ? element.first_name + " " : " ";
                    to += element.middle_name ? element.middle_name + " " : "";
                    to += element.last_name ? element.last_name + " " : "";
                }
                if (index == 0) {
                    purchaser1 = to;
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

            var and_to = "";

            var purchaser_solicitor =
                self.file_opening.purchaser_solicitor &&
                self.file_opening.purchaser_solicitor.solicitor
                    ? self.file_opening.purchaser_solicitor.solicitor
                    : null;
            // if(purchaser_solicitor && purchaser_solicitor.law_firm && purchaser_solicitor.law_firm.firm_name)
            if (purchaser_solicitor) {
                and_to = purchaser_solicitor.first_name;
                and_to += purchaser_solicitor.middle_name
                    ? " " + purchaser_solicitor.middle_name
                    : "";
                and_to += purchaser_solicitor.last_name
                    ? " " + purchaser_solicitor.last_name
                    : "";
            }
            var sellers_names = "";

            var sellers = self.file_opening.sellers;
            sellers.forEach((element, index) => {
                var seller_name = "";
                if (element.salutation == "Corporation") {
                    seller_name += element.company_name
                        ? element.company_name + " "
                        : "";
                } else {
                    seller_name += element.first_name
                        ? element.first_name + " "
                        : "";
                    seller_name += element.middle_name
                        ? element.middle_name + " "
                        : "";
                    seller_name += element.last_name
                        ? element.last_name + " "
                        : "";
                }

                sellers_names +=
                    seller_name == "" ? Seller + " " + index + 1 : seller_name;
                if (index < sellers.length - 1 && index != sellers.length - 2) {
                    sellers_names += ",";
                } else if (index == sellers.length - 2) {
                    sellers_names += " and ";
                }

                sellers_names += " ";
            });

            var re_in =
                "Purchaser - " +
                purchaser1 +
                ", purchase from " +
                sellers_names;
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

            var seller1 = "";
            if (self.file_opening.sellers.length > 0) {
                seller1 += self.file_opening.sellers[0].first_name
                    ? self.file_opening.sellers[0].first_name + " "
                    : "";
                seller1 += self.file_opening.sellers[0].middle_name
                    ? self.file_opening.sellers[0].middle_name + " "
                    : "";
                seller1 += self.file_opening.sellers[0].last_name
                    ? self.file_opening.sellers[0].last_name + " "
                    : "";
                if (seller1 == "") {
                    seller1 = "Seller 1";
                }
            }
            var seller2 = "";
            if (self.file_opening.sellers.length > 1) {
                seller2 += self.file_opening.sellers[1].first_name
                    ? self.file_opening.sellers[1].first_name + " "
                    : "";
                seller2 += self.file_opening.sellers[1].middle_name
                    ? self.file_opening.sellers[1].middle_name + " "
                    : "";
                seller2 += self.file_opening.sellers[1].last_name
                    ? self.file_opening.sellers[1].last_name + " "
                    : "";
                if (seller2 == "") {
                    seller2 = "Seller 2";
                }
            }

            section1.push({
                children: [
                    new Paragraph({
                        heading: HeadingLevel.HEADING_1,
                        alignment: AlignmentType.CENTER,
                        children: [
                            new TextRun({
                                text: "Undertaking",
                                allCaps: true,
                                underline: "SINGLE"
                            })
                        ]
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "To:",
                                bold: true,
                                break: 1
                            }),
                            new TextRun("\t Purchasers " + to),
                            new TextRun({
                                text: "And To:\t",
                                bold: true,
                                break: 2
                            }),
                            new TextRun(and_to),
                            new TextRun({
                                text: "\tBarrister & Solicitor",
                                break: 1
                            }),
                            new TextRun({
                                text: "RE:\t",
                                bold: true,
                                break: 2
                            }),
                            new TextRun({
                                text: re_in
                            }),
                            new TextRun({
                                text: "\t" + re,
                                break: 1
                            })
                        ],
                        tabStops: [
                            {
                                type: TabStopType.LEFT,
                                // position: TabStopPosition.MAX,
                                position: 2000
                            }
                        ],
                        border: {
                            bottom: {
                                color: "auto",
                                space: 5,
                                value: "single",
                                size: 7
                            }
                        },
                        spacing: {
                            after: 200,
                            before: 200
                        }
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text:
                                    "IN CONSIDERATION of and notwithstanding the closing of the above transaction, we hereby undertake as follows:",
                                break: 1
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        }
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "VACANT POSSESSION: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    " To deliver a vacant possession of the premises on closing, unless stated otherwise in the Agreement" +
                                    " Keys to all entry mechanisms and/or access codes for entry to the premises, codes for security alarm systems, keys to mailboxes," +
                                    "  and to the garage shall be provided to the purchaser on closing, with the vendor handing these personally to the buyer, or" +
                                    "  through their solicitors;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "TAXES: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    " TO deliver the premises clear of any and all arrears of taxes, including property taxes and local development charges," +
                                    " along with outstanding interests and penalties up to the date of closing, and  to pay  the 2021 taxes inaccordance with the " +
                                    "Statements of Adjustments;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "UTILITIES: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    " TO pay off in full and settle the accounts, up to the date of closing, for any and all the utilities - including hydro-electric," +
                                    "water and gas service- that could lead to a lien against the property"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "ENCUMBRANCES and DISCHARGES: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "TO pay off and discharge any existing encumbrances, liens and mortgages, that are not being assumed by the purchasers, " +
                                    "in respect of the subject property that the Vendor’s solicitors have agreed, in writing, to delete from the title;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "CHATTELS: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "TO leave in a good working condition all chattels and fixtures on the premises, as specified in the Agreement of Purchase and " +
                                    "Sale, and free of any encumbrances, liens and claims of any kind whatsoever. Further, the Vendor transfers the ownership of such chattels to the buyer with effect from the date of closing;NOTEchattels are added in Declarations."
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "FUEL OIL: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "TO supply and pay for fuel oil, if applicable, as per the Statement of Adjustments;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "UFFI WARRANTY: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "TO warrant that no part of the property is insulated with Urea Formaldehyde Foam Insulation to the best of the Vendor’s knowledge and belief;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "PROPERTY: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "To leave the premises, including the floors, in a clean and tidy condition, dispose off all garbage, clutter and debris, " +
                                    "and remove all personal belongings from the subject property, including the basement, backyard, garage and space around the home, on closing;"
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "READJUSTMENTS: ",
                                bold: true
                            }),
                            new TextRun({
                                text:
                                    "To re-adust any item on the Statement of Adjustments, If found to be incorrect or incomplete, on demand."
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        numbering: {
                            reference: "my-custom-numbering",
                            level: 1
                        }
                    }),
                    new Paragraph({
                        children: [
                            new TextRun({
                                text:
                                    "DATED at \t\t\t this           day of  \t, " +
                                    self.currentYear() +
                                    ".",
                                break: 1
                            })
                        ],
                        spacing: {
                            after: 200,
                            before: 200
                        },
                        tabStops: [
                            {
                                type: TabStopType.LEFT,
                                // position: TabStopPosition.MAX,
                                position: 2000
                            }
                        ]
                    }),

                    new Paragraph({
                        children: [
                            new TextRun({
                                text: "_____________________________",
                                break: 1
                            }),
                            new TextRun({
                                text: seller1,
                                break: 1
                            }),
                            new TextRun({
                                text: "_____________________________",
                                break: 3
                            }),
                            new TextRun({
                                text: seller2,
                                break: 1
                            })
                        ],
                        alignment: AlignmentType.RIGHT,
                        spacing: {
                            before: 200
                        }
                    })
                ]
            });
            self.undertaking_content = section1;
        }
    }
};
</script>

<style></style>
