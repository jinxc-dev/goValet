<template>
  <div>
    <h5 class="info-text"> Let's start with the basic information (with validation)</h5>
    <div class="md-layout">
        <div class="md-layout-item md-size-40 md-small-size-100">
            <div class="pic-container">
                <div class="pic">
                    <div>
                        <img :src="image" />
                    </div>
                    <input type="file" name="image" @change="onFileChange">
                </div>
                <h6 class="description">Choose Parking Photo</h6>
            </div>
        </div>
        <div class="md-layout-item md-size-60 mt-4 md-small-size-100">
            <div class="md-layout">
                <div class="md-layout-item">
                    <md-field :class="[
                        {'md-valid': !errors.has('name')},
                        {'md-error': errors.has('name')}]">
                        <label>Name</label>
                        <md-input
                            v-model="name"
                            data-vv-name="name"
                            name="name"
                            required
                            v-validate="'required'">
                        </md-input>
                    </md-field>
                </div>
                <div class="md-layout-item">
                    <md-field>
                        <label>Name of legal tenant</label>
                        <md-input
                            v-model="t_name"
                            data-vv-name="t_name"
                            name="t_name">
                        </md-input>
                    </md-field>
                </div>
            </div>
            <md-field :class="[
                {'md-valid': !errors.has('city')},
                {'md-error': errors.has('city')}]">
                <label>City</label>
                <md-input
                    v-model="city"
                    data-vv-name="city"
                    name="city"
                    required
                    v-validate="'required'">
                </md-input>
            </md-field>
            <md-field :class="[
                {'md-valid': !errors.has('state')},
                {'md-error': errors.has('state')}]">
                <label>State</label>
                <md-input
                    v-model="state"
                    data-vv-name="state"
                    name="state"
                    required
                    v-validate="'required'">
                </md-input>
            </md-field>
            <div class="md-layout">
                <div class="md-layout-item">
                    <md-field>
                        <label>Zip Code</label>
                        <md-input
                            v-model="zip_code"
                            data-vv-name="zip_code"
                            name="zip_code">
                        </md-input>
                    </md-field>
                </div>
                <div class="md-layout-item">
                    <md-field >
                        <label>Country</label>
                        <md-select v-model="country" name="country">
                            <md-option value="USA">USA</md-option>
                            <md-option value="Canada">Canada</md-option>
                        </md-select>
                    </md-field>
                </div>
            </div>
        </div>

    </div>
  </div>
</template>
<script>
export default {
    data() {
        return {
            image: require("@/../images/image-empty.jpg"),
            name: 'AAAAA',
            t_name: '',
            zip_code:'12345678',
            state:'Phoenix',
            city:'Hilleman Way',
            country: 'USA',
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
                this.$emit('on-validated', res);
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
}
</script>
<style lang="scss" scoped>

.pic-container {
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
