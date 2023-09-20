<template>
    <div class="form-horizontal">
        <div class="card-header py-1">
            <span><strong>Compliance</strong></span>
        </div>
        <div class="card-body">
              <fieldset class="fieldset">
                    <table class="table">
                        <tbody>

                            <tr>
                                <td>
                                    <strong>
                                   Letter to Tax Department:
                                   </strong>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Letter to Condominium Corporation:</strong></td>
                                <td></td>
                            </tr>
                               <tr>
                                <td><strong>Letter to cancel change account for Rental Items:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Air-Conditioner, Furnance, Hot Water Tank </strong></td>
                                <td></td>
                            </tr>
                             <tr>
                                <td></td>
                                <td></td>
                            </tr>
                             <tr>
                                <td colspan="2"><strong>Compliances</strong></td>
                            </tr>
                            <tr>
                                <td>Tax Department</td>
                                <td>
                                    <compliance-document v-if="show"
                                        file_name="tax_department"
                                        compliance_type="tax"
                                        :city_id = "city_id"
                                        :client_name="client_name"
                                        :client_sub_title="client_sub_title"
                                        :client_address="client_address"
                                        :client_phone="client_phone"
                                        :client_email="client_email"
                                        :departments="departments"
                                        :file_opening="file_opening"
                                        >
                                    </compliance-document>
                                </td>
                            </tr>
                             <tr>
                                <td>Water </td>
                                <td>
                                    <compliance-document v-if="show"
                                        file_name="water_department"
                                        compliance_type="water"
                                        :city_id = "city_id"
                                        :client_name="client_name"
                                        :client_sub_title="client_sub_title"
                                        :client_address="client_address"
                                        :client_phone="client_phone"
                                        :client_email="client_email"
                                        :departments="departments"
                                        :file_opening="file_opening"
                                        >
                                    </compliance-document>
                                </td>
                            </tr>
                             <tr>
                                <td>Hydro</td>
                                <td>
                                    <compliance-document v-if="show"
                                        file_name="hydro_department"
                                        compliance_type="hydro"
                                        :city_id = "city_id"
                                        :client_name="client_name"
                                        :client_sub_title="client_sub_title"
                                        :client_address="client_address"
                                        :client_phone="client_phone"
                                        :client_email="client_email"
                                        :departments="departments"
                                        :file_opening="file_opening"
                                        >
                                    </compliance-document>
                                </td>
                            </tr>
                             <tr>
                                <td>Enbridge</td>
                                <td>
                                    <compliance-document v-if="show"
                                        file_name="gas_department"
                                        compliance_type="gas"
                                        :city_id = "city_id"
                                        :client_name="client_name"
                                        :client_sub_title="client_sub_title"
                                        :client_address="client_address"
                                        :client_phone="client_phone"
                                        :client_email="client_email"
                                        :departments="departments"
                                        :file_opening="file_opening"
                                        >
                                    </compliance-document>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
        </div>
    </div>
</template>

<script>
import ComplianceDocument from './ComplianceDocument.vue';
export default {
  components: { ComplianceDocument },
    props:[
        'client_name',
        'client_sub_title',
        'client_address',
        'client_phone',
        'client_email',
        'file_opening',
    ],
    data:function(){
        return {
            departments:[],
            show:false
        }
    },

    computed:{
        city_id:function(){
            var city  =  0;
            city = this.file_opening.property ?  this.file_opening.property.city_id :0
            return city;
        },



    },

    mounted:function(){
          if(this.city_id > 0){
             this.getCityDepartments();
         }
    },

    methods:{
        isComponentDirty(){
            return false;
        },

        getCityDepartments:function(){
            var self = this;
            self.show = false;
            axios.get(Munshi.base_url+'/city-departments/'+this.city_id)
            .then(function(response){
                console.log(response);
                self.departments = response.data.city_departments;
                Utilities.refreshComponent(self,'show');
            })
            .catch(function(error){
                console.log(error);
            })
        },

    }
}
</script>

<style>

</style>
