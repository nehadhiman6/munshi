<template>
    <div>
        <!-- FOR image preview Only -->
        <fieldset class="image-fieldset">
            <div :id="'aniimated-thumbnials'+random" >
                <div class="iw-attached-img-area iw-attachment-large">
                    <div class="row">
						<div class="col-md-3">
								<a class="iw-thumbnail-gallery" :href="base_url+'/'+path+'/'+document.resource[idLabel]" >
									<figure>
										<img :src="base_url+'/'+pathThumbnail+'/'+document.resource[idLabel]" />
										<figcaption  class="text-center" ><span v-if="document.resource.attachment" v-text="getdocument.resourceName(document.resource.attachment.document.resource_name)"></span></figcaption>
									</figure>
								</a>
                                  <a :href="base_url+'/'+path+'/'+document.resource[idLabel]"> Download</a>
						</div>
						<div class="col-md-9">
							<div class="row">
								<div class="col-md-4">
									 <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('documents.'+index+'.doc_type') }">
                                        <label for="doc_type" class="in-label-title required">Type</label>
                                        <document-file-type-select  v-if="show" :index="index" :initials= "initials" :selected="selected" v-model="document.doc_type"></document-file-type-select>
                                        <span id="basic-msg" v-if="form.errors.get('documents.'+index+'.doc_type') " class="invalid-feedback">{{ form.errors.get('documents.'+index+'.doc_type')  }}</span>
                                    </div>
								</div>
								<div class="col-md-4">
									 <div class="form-group" v-bind:class="{ 'is-invalid': form.errors.get('documents.'+index+'.document_date') }">
                                        <label for="document_date" class="in-label-title required">Date</label>
                                        <date-picker v-model ="document.document_date" :className="index+'document_date'"></date-picker>
                                        <span id="basic-msg" v-if="form.errors.get('documents.'+index+'.document_date')" class="invalid-feedback">{{ form.errors.get('documents.'+index+'.document_date') }}</span>
                                    </div>
								</div>
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subject" class="in-label-title required">Subject</label>
                                        <input class="form-control" v-bind:class="{ 'is-invalid':  form.errors.get('documents.'+index+'.subject') }" type="text" v-model ="document.subject">
                                        <span id="basic-msg" v-if=" form.errors.get('documents.'+index+'.subject')" class="invalid-feedback">{{  form.errors.get('documents.'+index+'.subject') }}</span>
                                    </div>
								</div>
								<div class="col-md-12">
                                    <div class="form-row align-items-end">
									 <div class="form-group">
                                        <label for="remarks" class="in-label-title ">Remarks</label>
                                        <textarea class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('documents.'+index+'.remarks') }"  v-model ="document.remarks"></textarea>
                                        <span id="basic-msg" v-if="form.errors.get('documents.'+index+'.remarks')" class="invalid-feedback">{{ form.errors.get('documents.'+index+'.remarks') }}</span>
                                    </div>
                                    <div class="form-group col-md-2">
									<div v-if='showRemove' class="topright bg-danger text-white iw-remove-upload-btn d-inline-block mb-0" @click.prevent="$emit('removeAttachment',index)"><span class="mdi mdi-delete"></span>Remove</div>
								    </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
                    <hr>
				</div>
			</div>
		</fieldset>
	</div>
</template>
<script>
	import DatePicker from '../../../BasicComponents/DatePicker.vue';
	import DocumentFileTypeSelect from '../../SelectComponents/DocumentFileTypeSelect.vue';
	export default {
		components: { DatePicker, DocumentFileTypeSelect },
		props:{
			document:{ type:Object, default:'' },
			idLabel:{type:String,default:'id'},
			path:String,
			index:{type:[String,Number]},
			pathThumbnail:String,
			type:{ type:String, default:'single'},
			showDescription:{type:Boolean,default:false},
			docTypes:{type:Array,default:function(){return []}},
			showRemove:{type:Boolean,default:false},
			form:{type:Object,default:null}
		},
		data:function() {
			return {
				data:[],
				startIndex:0,
				base_url:window[appname]['base_url'],
				random:Math.floor(Math.random() * 100000)+'M'+Math.floor(Math.random() * 1000000),
				initials:[],
				selected:[],
				show:false
			}
		},
		mounted:function () {
			var self = this;
			self.launchGallery();
			if(this.document.doc_type != ''){
				this.initials = [{'id':this.document.doc_type,'text':this.document.doc_type}];
				this.selected = [this.document.doc_type];
			}
			this.show=true;
		},
		methods:{
			launchGallery:function() {
				var self = this;
				var lightgallery = $('#aniimated-thumbnials'+this.random).lightGallery({
					selector: '.iw-thumbnail-gallery',
					videojs: true,
					index:4,
					escKey: true,
					addClass: 'iw-lightbox',
					showThumbByDefault: false,
					share: false,
					loop:self.loop,
					index:self.startIndex,
					}).on('onBeforeClose.lg',function(event, index, fromTouch, fromThumb){
					self.$emit('resetImageArr');
				});

			},

			getFileName:function(str){
				if(str.length > 12){
					var str = str.substring(0,8) +'.....'+ str.substring(str.length-4, str.length);
				}
				return str;
			},
		},
	}
</script>

<style>

	div.lg-backdrop {
	background-color: rgba(0, 0, 0, .7);
	}

	div.iw-lightbox.lg-outer {
	z-index: 1061 ;
	}
	div.iw-lightbox.lg-outer {
	z-index: 9999 ;
	}

	div.lg-toolbar {
    background-color: #000;
    height: 60px;
	/* z-index: -1; */
	}

	div.lg-backdrop.in {
    opacity: 1;
    z-index: 1059 !important;
	}

	.filepond--file{
    cursor: pointer
	}
	.iw-attached-img-area figure {
    display: block;
    position: relative;
	}

	.iw-thumbnail-gallery img{
    width: 100%;
    height: 130px;
    padding: 1px;
    object-fit: contain;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
	}

	.image-fieldset{
    border: none;
    padding: 11px;
    margin: 10px 0;
    padding:0
	}
	#aniimated-thumbnials {
    display: flex;
    flex-wrap: wrap;
	}

	div#aniimated-thumbnials .topright {
    text-align: center;
	}
	.iw-attached-img-area {
    position: relative;
	}
	div#aniimated-thumbnials .topright {
    text-align: center;
    position: absolute;
    padding: 2px 10px;
    top: 0;
    right: 4px;
    cursor: pointer;
	}
	.iw-remove-upload-btn {
    display: table;
    padding: 5px 10px;
    margin: 10px auto;
    font-size: 13px;
    cursor: pointer;
	}

	.iw-remove-upload-btn > span.mdi {
    display: inline-block;
    margin-right: 5px;
    font-size: 15px;
	}
    .iw-attachment-large figure >img {
    height: 178px;
}
</style>
