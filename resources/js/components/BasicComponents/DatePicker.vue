<template>
	<div :id="'dp-'+_uid">
		<input class='form-control' v-bind:class="className" type="text" placeholder ="MM-DD-YYYY" :id="ele_id"
			autocomplete="Off" :disabled="disabled"
            @blur.prevent="lostFocus($event)"
			>
        <slot></slot>
	</div>
</template>

<script type="text/javascript">
	export default{
		props:['value','className','disabled','startDate','endDate','todayDate','yearsRange'],
        watch: {
            value: {
                handler: function(val, oldval) {
                    var self = this;
                    console.log('dt:', self.className, val, oldval);
                    $("." + self.className).datepicker(
                        'setDate', val
                    );
                },
                immediate: false
            }
        },
        data() {
            return {
                ele_id: 'dp-input-'+this._uid
            }
        },
		mounted() {
			var self = this;
			if(typeof(self.className) == "undefined"){
				self.className = "date-Btn"
            }
            if(typeof(self.yearsRange) == "undefined"){
                self.yrsRange = "-100:+0";
            } else {
                self.yrsRange = self.yearsRange;
            }
			$("#" + self.ele_id).datepicker({
				dateFormat: "mm-dd-yy",
                // format: 'dd-mm-yyyy',
                yearRange: self.yrsRange,
				changeMonth: true,
				changeYear: true,
				minDate: self.startDate,
				maxDate: self.endDate,
				onSelect: function(dateText) {
					// self.value = dateText;
					self.updateValue(dateText);
				},
			});

			var initialValue = self.value == "" ? self.todayDate : self.value;
            console.log('initialValue', self.className, initialValue);
            self.$nextTick(function() {
                $("#" + self.ele_id).datepicker(
                    'setDate', initialValue
                )
            });
            self.updateValue(initialValue);

            // console.log('dt: ',self.value);


			// if(self.value !=""){
			// 	$("." + self.className).datepicker(
			// 		'setDate', self.value
			// 	);
            //     self.updateValue(self.value);
			// }
		},
		methods: {
			updateValue: function (value) {
				this.$emit('input', value);
			},
            lostFocus(e) {
                var self = this;
                if(! $(e.target).val()) {
                    this.updateValue('');
                } else {
					self.updateValue($(e.target).val());
                }
            }
		}
	}
</script>
