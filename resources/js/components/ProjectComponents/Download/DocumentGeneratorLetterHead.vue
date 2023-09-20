<template>
    <button
        class="btn"
        :class="
            element_type == 'span'
                ? 'btn-link  text-primary p-0'
                : 'btn-primary'
        "
        @click.prevent="getImageContent"
    >
        <!-- <i class="far fa-file-word"></i> -->
        <span v-text="caption"></span>
    </button>
</template>

<script>
import {
    BorderStyle,
    AlignmentType,
    Document,
    HeadingLevel,
    Packer,
    Paragraph,
    TabStopPosition,
    TabStopType,
    Table,
    TextRun,
    ImageRun,
    TableRow,
    TableCell,
    WidthType,
} from "docx";
export default {
    props: {
        creator: {
            default: "",
        },

        description: {
            default: "example",
        },

        title: {
            default: "My Document",
        },

        element_type: {
            default: "span",
        },

        background: {
            default: function () {
                return {
                    color: "FFFFFF",
                };
            },
        },
        caption: {
            default: "Genereate.docx",
        },

        content: {
            default: function () {
                return [
                    {
                        properties: {
                            type: docx.SectionType.CONTINUOUS,
                        },
                        children: [
                            new Paragraph({
                                children: [
                                    new TextRun("Lorem Ipsum Foo Bar"),
                                    new TextRun("Hello World"),
                                ],
                            }),
                        ],
                    },
                ];
            },
        },

        fileName: {
            default: "example",
        },

        client_name: {
            default: "client_name",
            type: String,
        },
        client_sub_title: {
            default: "client_sub_title",
            type: String,
        },
        client_address: {
            default: "client_address",
            type: String,
        },
        client_phone: {
            default: "client_phone",
            type: String,
        },
        client_email: {
            default: "client_email",
            type: String,
        }

    },

    data: function () {
        return {
            image_exists: true,
            header_added: false,
        };
    },

    methods: {
        imageExists: function (url, callback) {
            var img = new Image();
            img.onload = function () {
                callback(true);
            };
            img.onerror = function () {
                callback(false);
            };
            img.src = url;
        },

        getImageContent: function () {
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
                    };
                });
            };

            var image_url = Munshi.base_url + "/assets/img/letter-pad.png";

            this.imageExists(image_url, function (exists) {
                console.log("RESULT: url=" + image_url + ", exists=" + exists);
                self.image_exists = exists;
                getBase64FromUrl(image_url).then(function (url) {
                    self.getDoc(
                        url.replace(/^data:image\/(png|jpg);base64,/, "")
                    );
                });
            });
        },
        getDoc: function (image_url) {
            var self = this;
            var client_address_array = [];
            var client_add = this.client_address.split("/");

            client_add.forEach((element, index) => {
                var br = index == 0 ? 0 : 1;
                client_address_array.push(
                    new TextRun({
                        text: element,
                        break: br,
                        color: "000000",
                        // color:'gray'
                    })
                );
            });
            var child = self.image_exists
                ? [
                      new TableCell({
                          borders: {
                              top: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              bottom: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              left: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              right: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                          },
                          children: [
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_1,
                                  children: [
                                      new TextRun({
                                          text: this.client_name,
                                          bold: true,
                                          italics: true,
                                          color: "000000",
                                          size: 40,
                                      }),
                                  ],
                              }),
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_2,
                                  children: [
                                      new TextRun({
                                          text: this.client_sub_title.replaceAll(
                                              "&amp;",
                                              "&"
                                          ),
                                          color: "000000",
                                      }),
                                  ],
                              }),
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_3,
                                  children: client_address_array,
                              }),
                          ],
                      }),
                      new TableCell({
                          // width: {
                          //     size: 100,
                          //     type: WidthType.PERCENTAGE
                          // },
                          borders: {
                              top: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              bottom: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              left: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              right: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                          },
                          children: [
                              new Paragraph({
                                  alignment: AlignmentType.CENTER,
                                  children: [
                                      new ImageRun({
                                          data: Buffer.from(
                                              image_url,
                                              "base64"
                                          ),
                                          transformation: {
                                              width: 100,
                                              height: 100,
                                          },
                                      }),
                                  ],
                              }),
                          ],
                      }),
                  ]
                : [
                      new TableCell({
                          borders: {
                              top: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              bottom: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              left: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                              right: {
                                  style: BorderStyle.NONE,
                                  size: 0,
                                  color: "FFFFFF",
                              },
                          },
                          children: [
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_1,
                                  children: [
                                      new TextRun({
                                          text: this.client_name,
                                          bold: true,
                                          italics: true,
                                          color: "000000",
                                          size: 40,
                                      }),
                                  ],
                              }),
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_2,
                                  children: [
                                      new TextRun({
                                          text: this.client_sub_title.replaceAll(
                                              "&amp;",
                                              "&"
                                          ),
                                          color: "000000",
                                      }),
                                  ],
                              }),
                              new Paragraph({
                                  alignment: AlignmentType.LEFT,
                                  heading: HeadingLevel.HEADING_3,
                                  children: client_address_array,
                              }),
                          ],
                      }),
                  ];
            const table = new Table({
                width: {
                    size: 100,
                    type: WidthType.PERCENTAGE,
                },
                rows: [
                    new TableRow({
                        children: child,
                    }),
                    new TableRow({
                        children: [
                            new TableCell({
                                borders: {
                                    top: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "000000",
                                    },
                                    bottom: {
                                        style: BorderStyle.SINGLE,
                                        size: 1,
                                        color: "000000",
                                    },
                                    left: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    right: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                },
                                children: [],
                            }),
                            new TableCell({
                                borders: {
                                    top: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "000000",
                                    },
                                    bottom: {
                                        style: BorderStyle.SINGLE,
                                        size: 1,
                                        color: "000000",
                                    },
                                    left: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    right: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                },
                                children: [],
                            }),
                        ],
                    }),

                    // ********
                    new TableRow({
                        children: [
                            new TableCell({
                                borders: {
                                    top: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    bottom: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    left: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    right: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                },
                                children: [
                                    new Paragraph({
                                        alignment: AlignmentType.LEFT,
                                        children: [
                                            new TextRun({
                                                text: this.client_phone,
                                                heading: HeadingLevel.HEADING_2,
                                            }),
                                        ],
                                    }),
                                ],
                            }),
                            new TableCell({
                                borders: {
                                    top: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    bottom: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    left: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                    right: {
                                        style: BorderStyle.NONE,
                                        size: 0,
                                        color: "FFFFFF",
                                    },
                                },
                                children: [
                                    new Paragraph({
                                        alignment: AlignmentType.RIGHT,
                                        children: [
                                            new TextRun({
                                                text: this.client_email,
                                                heading: HeadingLevel.HEADING_2,
                                                color: "0645AD",
                                            }),
                                        ],
                                    }),
                                ],
                            }),
                        ],
                    }),
                    // ****
                ],
            });
            var header = {
                children: [table],
            };
            if (this.header_added == false) {
                this.header_added = true;
                if (self.content.length > 0) {
                    self.content[0].children.unshift(table);
                } else {
                    // self.content.push(header);
                }
            }
            // Add paragraph in the document
            var doc = new docx.Document({
                creator: self.creator,
                description: self.description,
                title: self.title,
                background: self.background,
                sections: self.content,
                numbering: {
                    config: [
                        {
                            reference: "my-custom-numbering",
                            levels: [
                                {
                                    level: 0,
                                    format: "upperRoman",
                                    text: "%1",
                                    alignment: AlignmentType.START,
                                    style: {
                                        paragraph: {
                                            indent: { left: 720, hanging: 260 },
                                        },
                                    },
                                },
                                {
                                    level: 1,
                                    format: "decimal",
                                    text: "%2.",
                                    alignment: AlignmentType.START,
                                    style: {
                                        paragraph: {
                                            indent: {
                                                left: 1440,
                                                hanging: 980,
                                            },
                                        },
                                    },
                                },
                                {
                                    level: 2,
                                    format: "lowerLetter",
                                    text: "%3)",
                                    alignment: AlignmentType.START,
                                    style: {
                                        paragraph: {
                                            indent: {
                                                left: 2160,
                                                hanging: 1700,
                                            },
                                        },
                                    },
                                },
                                {
                                    level: 3,
                                    format: "upperLetter",
                                    text: "%4)",
                                    alignment: AlignmentType.START,
                                    style: {
                                        paragraph: {
                                            indent: {
                                                left: 2880,
                                                hanging: 2420,
                                            },
                                        },
                                    },
                                },
                            ],
                        },
                    ],
                },
            });

            Packer.toBlob(doc).then((blob) => {
                // saveAs from FileSaver will download the file
                FileSaver.saveAs(blob, self.fileName + ".docx");
            });
        },
    },
};
</script>

<style></style>
