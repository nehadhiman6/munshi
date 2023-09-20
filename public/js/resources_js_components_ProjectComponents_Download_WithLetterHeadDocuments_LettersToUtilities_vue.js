"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ProjectComponents_Download_WithLetterHeadDocuments_LettersToUtilities_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var docx__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! docx */ "./node_modules/docx/build/index.js");
/* harmony import */ var docx__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(docx__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['client_name', 'client_sub_title', 'client_address', 'client_phone', 'client_email', 'file_opening_id', 'file_opening'],
  computed: {
    componentInstance: function componentInstance() {
      var name = lh_no;
      return function () {
        return __webpack_require__("./resources/js/components/ProjectComponents/Download lazy recursive ^\\.\\/.*$")("./".concat(name));
      };
    }
  },
  data: function data() {
    return {
      content: ''
    };
  },
  mounted: function mounted() {
    this.getContent();
  },
  methods: {
    getContent: function getContent() {
      var self = this;
      var section = [];
      var current_date = moment().format('LL');
      var closing_date = self.file_opening.closing_date ? moment(self.file_opening.closing_date, 'MM-DD-YYYY').format("LL") : "";
      var seller1 = self.file_opening.sellers && self.file_opening.sellers.length > 0 ? self.file_opening.sellers[0].name : '';
      var purchaser1 = self.file_opening.purchasers && self.file_opening.purchasers.length > 0 ? self.file_opening.purchasers[0].name : '';
      var firm_addr1 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line1 : '';
      var firm_addr2 = self.file_opening.company && self.file_opening.company.solicitor && self.file_opening.company.solicitor.address ? self.file_opening.company.solicitor.address.addr_line2 : '';
      var acronym = self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name_initials : '';
      var dept = self.file_opening.property && self.file_opening.property.city && self.file_opening.property.city.departments.length > 0 ? self.file_opening.property.city.departments[0] : null;
      section.push({
        children: [new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: current_date,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: dept ? dept.department_name : '',
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Attention:  " + (dept ? dept.department_type + ' Department' : ''),
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: dept ? dept.addr_line1 : '',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: dept ? dept.addr_line2 : '',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Dear Sir or Madam:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "RE:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t ' + purchaser1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t ' + firm_addr1 + ' ' + firm_addr2,
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t Closing Date:' + '\t ' + closing_date,
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t Our File No:' + '\t ' + self.file_opening.file_no,
            "break": 1
          })],
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
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Kindly arrange for the " + (dept ? dept.deprtment_type : '') + " meter to be read on the said closing date."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Thank you for your co-operation."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Yours very truly,",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name : '',
            "break": 3
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: acronym,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.PageBreak()]
        }), // 2nd page
        new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: current_date,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Alectra Utilities",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Attention: Hydro Department",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "175 Sandalwood Pkwy W",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Brampton, ON L7A 1E8",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Dear Sir or Madam:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "RE:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t purchase from'
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t 1090 Peter Robertson Blvd, Brampton',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t Closing Date: November 9, 2021',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t My File No.: ' + ' 11-303',
            "break": 1
          })],
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
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Kindly arrange for the hydro meter to be read on the said closing date."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Thank you for your co-operation."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Yours very truly,",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: self.client_name,
            "break": 3
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: acronym,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.PageBreak()]
        }), // 3rd page
        new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: current_date,
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Enbridge Gas Distribution Inc.",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Attention: Gas Department",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "50 Keil Dr N",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "PO Box 2001",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Chatham, ON N7M 5M1",
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Dear Sir or Madam:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "RE:",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t purchase from'
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t 1090 Peter Robertson Blvd, Brampton',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t Closing Date: November 9, 2021',
            "break": 1
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: '\t My File No.: ' + ' 11-303',
            "break": 1
          })],
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
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "I am the solicitor for , the purchaser in the above transaction which is scheduled to be completed on November 9, 2021."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Kindly arrange for the gas meter to be read on the said closing date."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Thank you for your co-operation."
          })],
          spacing: {
            after: 200,
            before: 200
          }
        }), new docx__WEBPACK_IMPORTED_MODULE_0__.Paragraph({
          children: [new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: "Yours very truly,",
            "break": 2
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: self.file_opening.company && self.file_opening.company.solicitor ? self.file_opening.company.solicitor.name : '',
            "break": 3
          }), new docx__WEBPACK_IMPORTED_MODULE_0__.TextRun({
            text: acronym,
            "break": 2
          }) // new PageBreak(),
          ]
        })]
      });
      console.log(section);
      self.content = section;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LettersToUtilities.vue?vue&type=template&id=e9d542de& */ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de&");
/* harmony import */ var _LettersToUtilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LettersToUtilities.vue?vue&type=script&lang=js& */ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _LettersToUtilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__.render,
  _LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LettersToUtilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LettersToUtilities.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LettersToUtilities_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de&":
/*!******************************************************************************************************************************************!*\
  !*** ./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de& ***!
  \******************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LettersToUtilities_vue_vue_type_template_id_e9d542de___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LettersToUtilities.vue?vue&type=template&id=e9d542de& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ProjectComponents/Download/WithLetterHeadDocuments/LettersToUtilities.vue?vue&type=template&id=e9d542de& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(_vm.componentInstance, {
    tag: "component",
    attrs: {
      caption: "Letters to Utilities",
      "file-name": "letters_to_utilities" + _vm.file_opening.file_no,
      content: _vm.content,
      client_name: _vm.client_name,
      client_sub_title: _vm.client_sub_title,
      client_address: _vm.client_address,
      client_phone: _vm.client_phone,
      client_email: _vm.client_email,
    },
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);