<template>
    <span>
        <span @click="openFileBrowser">
            <slot name="upload-button">
                <i class="btn btn-xs btn-primary fa fa-upload"></i>
            </slot>
        </span>
        <form :id="'form-' + _uid">
            <input :id="'upload-input-' + _uid"
                type="file"
                :name="multiple ? 'files[]' : 'file'"
                :multiple="multiple"
                class="hidden"
                @change="upload">
        </form>
    </span>
</template>

<script>

    export default {
        props: {
            multiple: {
                type: Boolean,
                default: false
            },
            params: {
                type: Object,
                default() {
                    return {}
                }
            },
            url: {
                type: String,
                required: true
            },
            fileSizeLimit: {
                type: Number,
                default: 8388608
            },
            validImageTypes: {
                type: Array,
                default() {
                    return ["image/gif", "image/jpeg", "image/png"];
                }
            },
        },
        data() {
            return {
                input: null,
                maxFileSize: this.fileSizeLimit <= 8388608 ? this.fileSizeLimit : 8388608,
            };
        },
        methods: {
            openFileBrowser() {
                this.input.click();
            },
            upload() {
                let formData = this.getFormData();

                axios.post(this.url, formData).then(response => {
                    this.resetInput();
                    this.$emit('uploaded', response.data);
                }).catch(error => {
                    this.resetInput();
                    if (error.response.data.level) {
                        toastr[error.response.data.level](error.response.data.message);
                    }
                });
            },
            getFormData() {
                let formData = new FormData(),
                    files = this.input.files;

                for (let i = 0; i < files.length; i++) {
                    if (!this.checkFileSize(files[i]) || !this.checkFileFormat(files[i])) {
                        continue;
                    }

                    formData.append("file_" + i, files[i]);
                }

                for (let property in this.params) {
                    formData.append(property, this.params[property]);
                }

                return formData;
            },
            checkFileSize(file) {
                if (file.size > this.maxFileSize) {
                    return toastr.warning('File Size Limit of ' + this.maxFileSize + ' Kb excedeed by ' + file.name);
                }

                return true;
            },
            checkFileFormat: function(file) {
                if (this.pictures && this.validImageTypes.indexOf(file.type) === -1) {
                    return toastr.warning('File ' + file.name + ' is not of picture format');
                }

                return true;
            },
            resetInput () {
                let form = document.getElementById('form-' + this._uid);
                form.reset();
                this.$emit('reset-input');
            },
        },
        mounted() {
            this.input = document.getElementById('upload-input-' + this._uid);
        }
    }

</script>