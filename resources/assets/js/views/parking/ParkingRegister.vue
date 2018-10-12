<template>
    <div class="section">
        <div class="section container">
            <div class="md-layout">
                <div class="md-layout-item md-size-80 md-xsmall-size-100 mx-auto">
                <simple-wizard>
                    <template slot="header">
                        <h3 class="card-title" style="text-transform: uppercase">Register Parking Information</h3>
                        <h5 class="category">This information will let us know more about your parking spots.</h5>
                    </template>

                    <wizard-tab :before-change="() => validateStep('step1')">
                        <template slot="label">
                            General
                        </template>
                        <first-step ref="step1" @on-validated="onStepValidated"></first-step>
                    </wizard-tab>

                    <wizard-tab :before-change="() => validateStep('step2')">
                        <template slot="label" >
                            Parking Type
                        </template>
                        <second-step ref="step2" @on-validated="onStepValidated"></second-step>
                    </wizard-tab>

                    <wizard-tab :before-change="() => validateStep('step3')">
                        <template slot="label">
                            location
                        </template>
                        <third-step ref="step3" @on-validated="wizardComplete"></third-step>
                    </wizard-tab>
                </simple-wizard>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import FirstStep from './wizard/FirstStep.vue'
  import SecondStep from './wizard/SecondStep.vue'
  import ThirdStep from './wizard/ThirdStep.vue'
  import {SimpleWizard, WizardTab} from '@/components'

  export default {
    data() {
      return {
        wizardModel: {}
      }
    },
    components: {
      FirstStep,
      SecondStep,
      ThirdStep,
      SimpleWizard,
      WizardTab
    },
    methods: {
        validateStep(ref) {
            return this.$refs[ref].validate();
        },
        onStepValidated(validated, model) {
            this.wizardModel = {...this.wizardModel, ...model};
            console.log(this.wizardModel);
        },
        wizardComplete() {
            console.log('good job');
            // swal('Good job!', 'You clicked the finish button!', 'success');
            var formElement = document.querySelector("form");
            var data = new FormData(formElement);
            data.append('lot_type', this.wizardModel.lot_type);
            data.append('availability', this.wizardModel.type);
            // data.append('latitude', this.wizardModel.lat);
            // data.append('longitude', this.wizardModel.lng);

            console.log(this.wizardModel);

            axios.post('/api/parking/register', data, {headers: { 'Content-Type': 'multipart/form-data' }})
				.then(response => {
					// this.$router.push('/vehicle_profile');
					// this.$swal({
					// 	position: 'top-end',
					// 	type: 'success',
					// 	title: 'Your vehicle has been deleted',
					// 	showConfirmButton: false,
					// 	timer: 1000
					// })
				}).catch(error => {
					// console.log(error);
				})
        }
    }
  }
</script>
