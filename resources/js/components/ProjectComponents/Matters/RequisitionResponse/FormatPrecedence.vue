<template>
    <div class="row">
        <div class="col-md-8">
            <div class="iw-detail-box-area">
                <h4>Content:</h4>
                <div class="iw-precedent-text">
                    <div v-html="content.format_text"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="iw-detail-box-area">
                <h4>Precedents</h4>
                <ul class="iw-list-items">
                    <li class="" v-for="precedent in precedents" :key="precedent.id" @click.prevent="importPrecedent(precedent) ">{{precedent.name}}</li>
                </ul>
            </div>


        </div>
    </div>
</template>

<script>
export default {
    data:function(){
        return {
            content:"",
            precedents:[],
            base_url:Munshi.base_url
        }
    },
    mounted:function(){
        this.getPrecedents();
    },
    methods:{
        getPrecedents:function(){
            var self = this;
            axios.post(this.base_url+'/precedents/filtered')
            .then(function(response){
                console.log(response);
                self.precedents = response.data.results;
            })
            .catch(function(error){

            });
        },

        importPrecedent:function(precedent){
            this.content = precedent;
            this.$emit('closeTriggered',precedent.id,precedent)
        }
    }
}
</script>

<style>
.iw-detail-box-area h4 {
    font-size: 16px;
    font-weight: 600;
}

.iw-detail-box-area .iw-precedent-text {
    padding: 10px 10px;
    border: 1px solid #ccc;
    max-height: 170px;
    overflow-y: scroll;
    min-height: 170px
}
.iw-detail-box-area > ul.iw-list-items > li {
    border: 1px solid #ccc;
    display: block;
    padding: 5px 10px;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-right: 5px;
    background: rgb(3 34 145 / 10%);
    color: #031893;
    cursor: pointer;
    transition: 0.5s;
}

.iw-detail-box-area > ul.iw-list-items {
    margin: 0;
    padding: 0;
    list-style: none;
    max-height: 170px;
    overflow-y: scroll;
}

.iw-detail-box-area > ul.iw-list-items > li:hover {
    background: #031893;
    color: #fff;
    border-color: #031893;
}
.iw-detail-box-area > ul.iw-list-items > li.active {
    background: #031893;
    border-color: #031893;
    color: #fff;
}
</style>
