<template>
  <div>
    <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
    <div class="md-layout">
        <div class="md-layout-item md-size-40 md-small-size-100">
            <div class="pic-container">
                <div class="pic">
                    <div v-if="!image">
                        <img :src="avatar" class="pic-src" title="">
                    </div>
                    <div v-else>
                        <img :src="image" />
                    </div>
                    <input type="file" @change="onFileChange">
                </div>
                <h6 class="description">Choose Parking Photo</h6>
            </div>
        </div>
        <div class="md-layout-item md-size-60 mt-4 md-small-size-100">
            <div class="md-layout">
                <div class="md-layout-item">
                    <md-field :class="[
                        {'md-valid': !errors.has('name') && touched.name},
                        {'md-error': errors.has('name')}]">
                        <label>Name</label>
                        <md-input
                            v-model="name"
                            data-vv-name="name"
                            name="name"
                            required
                            v-validate="modelValidations.name">
                        </md-input>
                            <md-icon class="error" v-show="errors.has('name')">close</md-icon>
                            <md-icon class="success" v-show="!errors.has('name') && touched.name">done</md-icon>
                    </md-field>
                </div>
                <div class="md-layout-item">
                    <md-field :class="[
                        {'md-valid': !errors.has('t_name') && touched.t_name},
                        {'md-error': errors.has('t_name')}]">
                        <label>Tenant Name</label>
                        <md-input
                            v-model="t_name"
                            data-vv-name="t_name"
                            name="t_name">
                        </md-input>
                    </md-field>
                </div>
            </div>
            <md-field :class="[
                {'md-valid': !errors.has('city') && touched.city},
                {'md-error': errors.has('city')}]">
                <label>City</label>
                <md-input
                    v-model="city"
                    data-vv-name="city"
                    name="city"
                    required
                    v-validate="modelValidations.city">
                </md-input>
                    <md-icon class="error" v-show="errors.has('city')">close</md-icon>
                    <md-icon class="success" v-show="!errors.has('city') && touched.city">done</md-icon>
            </md-field>
            <md-field :class="[
                {'md-valid': !errors.has('state') && touched.state},
                {'md-error': errors.has('state')}]">
                <label>State</label>
                <md-input
                    v-model="state"
                    data-vv-name="state"
                    name="state"
                    required
                    v-validate="modelValidations.state">
                </md-input>
                    <md-icon class="error" v-show="errors.has('state')">close</md-icon>
                    <md-icon class="success" v-show="!errors.has('state') && touched.state">done</md-icon>
            </md-field>
            <div class="md-layout">
                <div class="md-layout-item">
                    <md-field :class="[
                        {'md-valid': !errors.has('zip') && touched.zip},
                        {'md-error': errors.has('zip')}]">
                        <label>Zip Code</label>
                        <md-input
                            v-model="zip"
                            data-vv-name="zip"
                            name="zip"
                            v-validate="modelValidations.zip">
                        </md-input>
                        <md-icon class="error" v-show="errors.has('zip')">close</md-icon>
                        <md-icon class="success" v-show="!errors.has('zip') && touched.zip">done</md-icon>
                    </md-field>
                </div>
                <div class="md-layout-item">
                    <md-field :class="[
                        {'md-valid': !errors.has('name') && touched.name},
                        {'md-error': errors.has('name')}]">
                        <label>Country</label>
                        <md-input
                            v-model="name"
                            data-vv-name="name"
                            name="name"
                            v-validate="modelValidations.name">
                        </md-input>
                    </md-field>
                </div>
            </div>
        </div>

    </div>
  </div>
</template>
<script>
import { SlideYDownTransition } from 'vue2-transitions'
  export default {
    components: {
      SlideYDownTransition
    },
    props: {
      avatar: {
        type: String,
        default: require("@/../images/image-empty.jpg")
      }
    },
    data() {
      return {
        image: '',
        single: null,
        name: 'sdfsfsfsfsdf',
        t_name: 'sdfsfsfsfsdf',
        email: '',
        zip:'12345678',
        state:'sdfsfsfsfsdf',
        city:'sdfsfsfsfsdf',
        touched: {
            lastName: false,
            zip: false
        },
        modelValidations: {
            name: {
                required: true,
                min: 5
            },
            city: {
                required: true,
                min: 2
            },
            state: {
                required: true,
                min: 2

            },
            t_name: {
                required: false,
                min: 5
            },
            zip: {
                numeric: true,
                min: 4
            }
        }
      }
    },
    methods: {
        handlePreview(file) {
            this.model.imageUrl = URL.createObjectURL(file.raw);
        },
        getError(fieldName) {
            return this.errors.first(fieldName)
        },
        validate() {
            return this.$validator.validateAll().then(res => {
                this.$emit('on-validated', res)
                return res
            })
        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    watch: {
        name () {
            this.touched.name = true
        },
        email () {
            this.touched.email = true
        },
        zip() {
            this.touched.zip = true;
        },
        city() {
            this.touched.city = true;
        },
        state() {
            this.touched.state = true;
        }
    }
  }
</script>
<style lang="scss" scoped>

.pic-container {
	// margin-top: 50px;
    cursor: pointer;
    position: relative;
    text-align: center;
}
.pic {
    -webkit-transition: all .2s;
    background-color: #999;
    border: 1px solid #ccc;
    color: #fff;
    // height: 400px;
    margin: 5px auto;
    overflow: hidden;
    transition: all .2s;
    width: 100%;
}

.pic-src {
    width: 100%;
}

.pic input[type=file] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0!important;
    position: absolute;
    top: 0;
    width: 100%;
}
</style>
