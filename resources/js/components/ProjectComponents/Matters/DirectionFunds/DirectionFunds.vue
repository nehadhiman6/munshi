<template>
    <div>
        <div class="iw-horizontal-tabs">
             <!-- <div class ="mb-1">
                <input class="btn iw-btn iw-btn-submit" value='SAVE' @click.prevent ="submitForm" type="submit">
            </div> -->

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-direction-fund-tab" data-toggle="tab" href="#nav-direction-fund" role="tab" aria-controls="nav-direction-fund" aria-selected="true">Direction Fund</a>
                    <!-- <a class="nav-item nav-link" id="nav-file-upload-tab" data-toggle="tab" href="#nav-file-upload" role="tab" aria-controls="nav-file-upload" aria-selected="false">File Uploads</a> -->
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-direction-fund" role="tabpanel" aria-labelledby="nav-direction-fund-tab">
                    <direction-fund
                        :form='form'
                        :permissions="permissions"
                        :file_opening_id="file_opening_id">
                    </direction-fund>

                </div>


                <!-- <div class="tab-pane fade" id="nav-file-upload" role="tabpanel" aria-labelledby="nav-file-upload-tab">
                    <file-upload-tab
                        target="statement_adjustment"
                        :form="form"
                        :file_opening_id="file_opening_id">
                    </file-upload-tab>
                </div> -->
            </div>

            <!-- <div class ="mt-4">
                <input class="btn iw-btn iw-btn-submit" value='SAVE' @click.prevent ="submitForm" type="submit">
            </div> -->
        </div>

    </div>
</template>

<script>
function getNewForm(){
    return new Form({
        file_opening_id:0,
        trust_ledgers:[
        ],
        resources:[]
    });
}
import DirectionFund from './DirectionFund.vue';
export default {
    props:['file_opening_id','permissions'],
    components: {
        DirectionFund,
     },
    data:function(){
        return {
            base_url:Munshi.base_url,
            form:getNewForm(),
        }
    },
    mounted:function(){
        this.form.file_opening_id = this.file_opening_id;
    },

}
</script>

<style>
.iw-horizontal-tabs .nav-item .nav-link {
    padding-right: 40px;
}

.iw-horizontal-tabs span.iw-close-tab {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
