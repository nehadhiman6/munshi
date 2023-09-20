<template>
    <div class="card mb-3">
        <div class="card-header">
            Role: {{ role.name }}
        </div>
            <div class="card-body">
                <table class="table table-striped table-theme table-bordered"  width= "100%">
                    <thead>
                        <tr>
                        <th>S.No.</th>
                        <th>Permission</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-for="(g, index) in opt_groups" :key="index">
                        <tr class="opt-grp-heading">
                            <th colspan="2">{{ g.opt_group }}</th>
                            <th>
                                <div class="check-box">
                                    <label>
                                        <input class="opt-group" :id="'opt-group-'+g.id" type="checkbox" :value="g.id" @click="togglePermissions($event, g.id)" >
                                    </label>
                                </div>
                            </th>
                        </tr>
                        <tr v-for="(p, index) in g.permissions" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ p.label }}</td>
                            <td>
                                <div class="check-box">
                                    <label>
                                        <input  v-model="permissions" type="checkbox" :value="p.id" @click="updateOptGrpStatus(g.id)">
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer">
                    <div>
                        <input class="btn iw-btn iw-btn-add btn-sm " type="submit" value="SAVE" @click.prevent="savePermissions">
                        <a class = "btn iw-btn iw-btn-cancel btn-sm " :href="back_url">BACK</a>
                    </div>

                    <div class="mt-3">
                        <ul class="alert alert-danger" v-if="hasErrors.length > 0">
                            <li v-for="(err,index) in hasErrors" :key="index">{{ err }}</li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    props: ['role','opt_groups', 'permissions'],
    data() {
        return {
            form_action: window[appname]['base_url']+'/roles/'+this.role.id+'/permissions',
            back_url: window[appname]['base_url']+'/roles',
            errors: {},
        }
    },
    mounted() {
        var self = this;
        $('.opt-group').map((i, og) => {
            $(og).prop('checked', self.allChecked($(og).val()));
        });
    },
    computed: {
        hasErrors() {
            return Object.keys(this.errors).map(key => {
                return this.errors[key][0];
            });
        }
    },
    methods: {
        savePermissions() {
            console.log("SAVE PERMISSION");
            var self = this;
            this.errors = {};
            var data = {
                permissions: this.permissions,
            }
            axios.post(this.form_action, {permissions: this.permissions})
            // .then(function(response) {
            //     console.log(response.data);
            // })
            // .catch(function(error) {
            //     console.log(error);
            //     if(error.response.status == 422) {
            //         self.errors = error.response.data.errors;
            //     }
            // });
        },
        getOptGroup(id) {
            return this.opt_groups.filter( g => g.id == id)[0];
        },
        togglePermissions(e, id) {
            var self = this;
            var checked = $(e.target).prop('checked');
            this.getOptGroup(id).permissions.map( p => {
                var key = self.permissions.indexOf(p.id);
                if(key !== -1 && checked == false) {
                    self.permissions.splice(key, 1);
                } else if(key === -1 && checked) {
                    self.permissions.push(p.id);
                }
            });
        },
        allChecked(id) {
            var self = this;
            var grp = this.getOptGroup(id);
            return grp.permissions.length === grp.permissions.filter( p => self.permissions.indexOf(p.id) !== -1).length;
        },
        updateOptGrpStatus(id) {
            var og = $('#opt-group-'+id)[0];
            this.$nextTick(function() {
                $(og).prop('checked', this.allChecked($(og).val()));
            });
        }
    }
}
</script>

<style>
.opt-grp-heading th {
    background-color: #03a9f4;
    font-size: large;
    color:white
}
</style>


