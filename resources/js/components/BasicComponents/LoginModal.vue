<template>
    <div id="sessionModal" class="modal fade" role="dialog"   data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Your session has expired! Please login again!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <input id="email"  v-bind:class="{ 'is-invalid': form.errors.get('email') }" type="email"  placeholder="Username" class="form-control" name="email" v-model="form.email" required autofocus>
                            </div>
                            <span id="basic-msg" v-if="form.errors.get('email')" class="invalid-feedback">{{ form.errors.get('email') }}</span>

                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                                <input id="password" v-bind:class="{ 'is-invalid': form.errors.get('password') }" type="password" placeholder="Password" class="form-control"  v-model="form.password" name="password" required>
                            </div>
                            <span id="basic-msg" v-if="form.errors.get('password')" class="invalid-feedback">{{ form.errors.get('password') }}</span>
                        </div>
                        <div class="float-right">
                            <div class="form-check pb-4">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary btn-block" @click.prevent="getToken()">
                                <strong> Login</strong>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    function getNewLoginForm(){
        return new Form({
            _token: '',
            email:'',
            password:'',
        });
    }
    export default {
        data:function(){
            return{
                form:getNewLoginForm(),
                interval_gap: (1000 * 10),
                check_interval: null,
            }
        },
        mounted() {
            var token = document.head.querySelector('meta[name="csrf-token"]');

            if (token) {
                this.form._token = token.content;

            } else {
                console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
            }

            // var self = this;
            // console.log('login setup');
            // this.check_interval = setInterval(function() {
            //     self.checkStatus();
            //     // console.log('ping');
            // }, self.interval_gap);
        },
        beforeDestroy() {
            // clearInterval(this.check_interval);
        },
        methods:{
            submitForm(){
                var self = this;
                // console.log('before login:', this.form._token);
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = this.form._token;
                axios.post(window[appname]['base_url']+'/login',this.form)
                .then(function (response) {
                    var token = response.data;
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                    $('meta[name="csrf-token"]').attr('content',token);
                    $('#sessionModal').modal('hide');
                    $.blockUI({'message':"you have successfully logged in."});
                    setTimeout(function () {
                        $.unblockUI();
                        // location.reload();
                    },2000);
                })
                .catch(function(err) {
                    if(err && err.response && err.response.status && err.response.status == 422){
                        self.form.errors.record(err.data.errors);
                    }
                });
            },
            getToken() {
                var self = this;
                var loading = window[appname]['block_loading'];
                window[appname]['block_loading'] = false;
                axios.get(window[appname]['base_url']+'/ajax-info')
                .then(function (response) {
                    console.log('response', response);
                    self.form._token = response.data;
                })
                .then(function() {
                    self.submitForm();
                })
                .catch(function(error){
                    console.log(error);
                })
                .finally(function(){
                    window[appname]['block_loading'] = loading;
                });
            },
        }

    }
</script>

<style>

</style>
