<template>
    <div>
        <div class="card mb-4">
            <div class="card-body">
				<fieldset class="fieldset ">
					<legend class='legend'>Firm Details</legend>
					<div class="form-row">
						<div class="col">
                            <div class="form-group">
                                <label for="name" class="in-label-title ">Firm Name</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('name') }" type="text" v-model ="form.name">
							<span id="basic-msg" v-if="form.errors.get('name')" class="invalid-feedback">{{ form.errors.get('name') }}</span>
                            </div>
						</div>
					</div>

				</fieldset>
			</div>
		</div>
        <div class="card mb-4">
			<div class="card-body">
				<fieldset class="fieldset mt-2">
                    <legend class='legend'>Address</legend>
                    <div class="form-row">
						<div class="col">
                            <div class="form-group">
                            <label for="number" class="in-label-title ">Number</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('number') }" type="text" v-model ="form.number">
							<span id="basic-msg" v-if="form.errors.get('number')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                            </div>
						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="street" class="in-label-title ">Street</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.street">
							<span id="basic-msg" v-if="form.errors.get('street')" class="invalid-feedback">{{ form.errors.get('street') }}</span>
                            </div>
						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="city_id" class="in-label-title ">City</label>
                                 <div class="input-group flex-nowrap mb-3">
                                        <div class="w-100">
                							<city-select  v-if="show" :initials="initialCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="form.city_id" @updateCity="updateCity"></city-select>
                                        </div>
                                        <div class="input-group-append" v-if="permissions['cities-modify'] == 'cities-modify'">
                                            <button class="btn iw-add-new-btn" @click.prevent="addCity()"><span class="mdi mdi-plus"></span></button>
                                        </div>
                                    </div>
							<span id="basic-msg" v-if="form.errors.get('city_id')" class="invalid-feedback">{{ form.errors.get('city_id') }}</span>
                            </div>
						</div>
					</div>
					<!-- <legend class='legend'>Address</legend> -->
					<!-- <div class="form-row">
						<div class="col">
                            <div class="form-group">
                                <label for="number" class="in-label-title ">Number</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('number') }" type="text" v-model ="form.number">
							<span id="basic-msg" v-if="form.errors.get('number')" class="invalid-feedback">{{ form.errors.get('number') }}</span>
                            </div>
						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="street" class="in-label-title ">Street</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('street') }" type="text" v-model ="form.street">
							<span id="basic-msg" v-if="form.errors.get('street')" class="invalid-feedback">{{ form.errors.get('street') }}</span>
                            </div>

						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="city_id" class="in-label-title ">City</label>
							<city-select  v-if="show" :initials="initialCity" :selected="selectedCity"  v-bind:class="{ 'is-invalid': form.errors.get('city_id') }" type="text" v-model ="form.city_id"></city-select>
							<span id="basic-msg" v-if="form.errors.get('city_id')" class="invalid-feedback">{{ form.errors.get('city_id') }}</span>
                            </div>
						</div>
					</div> -->
					<div class="form-row">
						<div class="col">
                            <div class="form-group">
                                <label for="province" class="in-label-title ">Province</label>
                                <!-- <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('province') }" disabled type="text" v-model ="form.province"> -->
                                <!-- <canadian-state-select v-if="show" v-model="form.province" :initials="initialProvince" :selected="selectedProvince"></canadian-state-select> -->
                                <input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('province') }" type="text" disabled v-model ="form.province">
                                <span id="basic-msg" v-if="form.errors.get('province')" class="invalid-feedback">{{ form.errors.get('province') }}</span>
                            </div>
						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="country" class="in-label-title ">Country</label>
							<input class="form-control" v-bind:class="{ 'is-invalid': form.errors.get('country') }" type="text" disabled v-model ="form.country">
							<span id="basic-msg" v-if="form.errors.get('country')" class="invalid-feedback">{{ form.errors.get('country') }}</span>
                            </div>
						</div>
						<div class="col">
                            <div class="form-group">
                                <label for="postal_code" class="in-label-title ">Postal Code</label>
							<input class="form-control" @input="postalCode('postal_code')" v-bind:class="{ 'is-invalid': form.errors.get('postal_code') }" type="text" v-model ="form.postal_code">
							<span id="basic-msg" v-if="form.errors.get('postal_code')" class="invalid-feedback">{{ form.errors.get('postal_code') }}</span>
                            </div>
						</div>
					</div>

					<div class ="mt-4">
						<input class="btn iw-btn iw-btn-submit" :value="form.form_id > 0 ? 'Update' : 'Save'" @click.prevent ="saveCompany" type="submit">
						<!-- <input class="btn iw-btn iw-btn-cancel" value ="Cancel" @click.prevent ="resetForm" type="submit" > -->
					</div>
				</fieldset>
			</div>

		</div>

		<employees
        :permissions="permissions">
		</employees>
             <city-form v-if="showCity"
                        @closeTriggered="closeCityModal"
                    >
                </city-form>

	</div>
</template>

<script>
    import CityForm from '../Masters/City/CityForm.vue';
	import Employees from '../Masters/Employees/Employees.vue';

	function getNewForm(){
		return new Form({
		'name':'',
		number:'',
		street:'',
		city_id:'',
		country:'',
		postal_code:'',
		province:''
	})
};
export default {
    props:['permissions'],
	components: { Employees, CityForm },

	data:function(){
		return {
			create_url:'companies',
			form:getNewForm(),
			base_url:Munshi.base_url,
			initialCity:[],
			selectedCity:[],
            initialProvince:[],
            selectedProvince:[],
			show:true,
            showCity:false
		}
	},
	mounted:function(){
        var self = this;
		this.getCompany();
        window.onbeforeunload = function (event) {
             var is_dirty = self.form.isDirty();
            if(is_dirty){
                return "You currently have unsaved changes!!";
                return "<h6>You currently have unsaved changes!!!\n\nAre you sure you want to exit without saving.\n\nChoose ‘Leave this page’ to exit without saving changes.\nChoose ‘Stay on this page’ to return.</h6>";
            }

        }
	},
	methods:{
		getCompany:function(){
			var self = this;
			this.show=false;
			axios.get('companies')
			.then(function(response){
				console.log(response.data);
				self.show=false;
				var company = response.data.company;
				self.form.name = company.name? company.name:'Firm Name here';
				Utilities.copyProperties(company,self.form);
				if(company.city){
					var city = company.city;
					self.initialCity = [{'text':city.city_name ,'id':city.id}];
					self.selectedCity = [city.id];
				}
                self.initialProvince = [{'id':company.province,'text':company.province}];
                self.selectedProvince = [company.province];
				self.show=true;
                self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
			})
			.catch(function(error){

			});
		},

		saveCompany:function(){
			var self = this;
            Utilities.showConfirmationPopMessage('Do you want to save the changes?',function(save){
                if(save == true){
                    self.form['postForm'](self.base_url+'/'+self.create_url)
                    .then(function(response){
                        Utilities.showToast(self,'success','Firm details updated successfully',2200,true);
                            self.form.copyData = JSON.parse(JSON.stringify(self.form.data()));
                        $('.collapse_company').toggle();
                    });
                }
            },true,false);

		},

		inputTitle:function(e){
			this.form.name = e.target.innerText;
			this.saveCompany();
		},

		editName:function(){
			$('.company_name_editable').focus();
		},

        updateCity:function(value,index,city){
            this.form.country = city.country;
            this.form.province = city.state;
        },
        addCity:function(){
            this.showCity = true;
        },
        closeCityModal:function(){
            this.showCity = false;
        },
        postalCode(field){
            this.form[field] =  this.form[field].toUpperCase();
            var str =  this.form[field];

            var matched = true;
            var x= '';
            switch(str.length) {
                case 1:
                    x = this.form[field].match(/[A-Z]/g);
                break;

                case 2:
                    x =this.form[field].match(/[A-Z][0-9]/g);
                break;

                case 3:
                    x = this.form[field].match(/[A-Z][0-9][A-Z]/g);
                break;

                case 4:
                    x = this.form[field].match(/[A-Z][0-9][A-Z][ ]/g);
                break;

                case 5:
                    x = this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9]/g);
                break;

                case 6:
                    x =this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z]/g);
                break;

                case 7:
                    x =this.form[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
            }
            if(x== null){
                console.log("not matched");
                this.form[field]=  this.form[field].substring(0, this.form[field].length - 1);
                 if(str.length == 4){
                       this.form[field]= this.form[field]+ ' ';
                }

            }

             if(str.length == 3){
                 this.form.address[field] =  this.form.address[field]+' ';
            }
              if(str.length > 7 ){
                this.form[field]  = this.form[field].substring(0, 7);
            }
            // var x = this.form.address[field].match(/[A-Z][0-9][A-Z][ ][0-9][A-Z][0-9]/g);
        }
    }
}
</script>

<style>

</style>
