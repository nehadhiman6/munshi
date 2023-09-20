require("./bootstrap");

import Form from "./core/Form";
import Utilities from "./core/Utilities";
import Toast from "vue-toastification";
window.Form = Form;
window.Utilities = Utilities;
window.Swal = require("sweetalert2");
window.docx = require("docx");
window.FileSaver = require("file-saver");

import Vue from "vue";
// for File uploads
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";

// image preview in file pond
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

import FilePondPluginFilePoster from "filepond-plugin-file-poster";
import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";

// file size validations
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFilePoster,
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType
);
window.Vue = require("vue").default;

import "vue-toastification/dist/index.css";

Vue.use(Toast, {
    transition: "Vue-Toastification__bounce", //Vue-Toastification__fade //Toastification__bounce //Toastification__slideBlurred
    maxToasts: 3,
    newestOnTop: true
});



window.Quill = require("quill"); // this needs to be declare globally

require("./project_components");
