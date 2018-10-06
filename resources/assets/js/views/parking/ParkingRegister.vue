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
                            Authorization
                        </template>
                        <second-step ref="step2" @on-validated="onStepValidated"></second-step>
                    </wizard-tab>

                    <wizard-tab :before-change="() => validateStep('step3')">
                        <template slot="label">
                            location
                        </template>
                        <third-step ref="step3"></third-step>
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
//   import swal from 'sweetalert2'
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
            return this.$refs[ref].validate()
        },
        onStepValidated(validated, model) {
            this.wizardModel = {...this.wizardModel, ...model}
        },
        wizardComplete() {
            console.log('good job');
            // swal('Good job!', 'You clicked the finish button!', 'success');
        }
    }
  }
</script>
