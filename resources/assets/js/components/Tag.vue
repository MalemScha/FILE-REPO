<template>
<div>

        <div class="modal-body">
            <div class="form-group">
                <label for="description" class="col-md-4 control-label">File Description</label>
                <textarea name="description" id="description"  class="form-control" placeholder="File Description" rows="4" v-model="description" required @keydown="errors.clear('description')"></textarea>
                <span style="color: red;" class="help-block" v-text="errors.get('description')"></span>
            </div>
            <div class="form-group">
                <input  type="file" name="files" id="files" required>

                <span style="color: red;" class="help-block" v-text="errors.get('files')"></span>
            </div>

            <div class="form-group">
                <label for="tags" class="col-md-4 control-label">Tags</label>

                <div @click="focusNewTag()" v-bind:class="{'read-only': readOnly}" class="vue-input-tag-wrapper form-control">
                                            <span v-for="(tag, index) in tags" class="input-tag">
                                              <span>{{ tag }}</span>
                                              <a v-if="!readOnly" @click.prevent.stop="remove(index)" class="remove"></a>
                                            </span>
                    <input id="tags" @keydown="errors.clear('tags')" name="tags[]" v-if="!readOnly" v-bind:placeholder="getPlaceholder()" type="text" v-model="newTag" v-on:keydown.delete.stop="removeLastTag()" v-on:keydown.enter.prevent.stop="addNew(newTag.toLowerCase())" class="new-tag" required/>
                </div>
                <span style="color: red;" class="help-block" v-text="errors.get('tags')"></span>

            </div>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" @click="addFile">Upload</button>
    </div>
    <div v-if="edit">
        <div class="modall is-active">
            <div class="modall-background"></div>
            <div class="modall-content">
                <div class=" modal-body">
                    <center><i style="color: deeppink;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only"></span><h1>Uploading File</h1></center>
                </div>
            </div>
        </div>
    </div>

    <div v-if="editing">
        <div class="modall is-active">
            <div class="modall-background"></div>
            <div class="modall-content">
                <div class=" modal-body">
                    <center><i style="color: limegreen;" class="fa fa-check fa-3x fa-fw"></i>
                        <h1>File Uploaded</h1></center>
                </div>
            </div>
        </div>
    </div>

</div>


</template>
<script>


    class Errors {
        /**
         * Create a new Errors instance.
         */
        constructor() {
            this.errors = {};
        }


        /**
         * Determine if an errors exists for the given field.
         *
         * @param {string} field
         */
        has(field) {
            return this.errors.hasOwnProperty(field);
        }


        /**
         * Determine if we have any errors.
         */
        any() {
            return Object.keys(this.errors).length > 0;
        }


        /**
         * Retrieve the error message for a field.
         *
         * @param {string} field
         */
        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }


        /**
         * Record the new errors.
         *
         * @param {object} errors
         */
        record(errors) {
            this.errors = errors;
        }


        /**
         * Clear one or all error fields.
         *
         * @param {string|null} field
         */
        clear(field) {
            if (field) {
                delete this.errors[field];

                return;
            }

            this.errors = {};
        }
    }



    /*eslint-disable*/
    const validators = {
        email : new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),
        url : new RegExp(/^(https?|ftp|rmtp|mms):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i),
        text : new RegExp(/^[a-zA-Z]+$/),
        digits : new RegExp(/^[\d() \.\:\-\+#]+$/),
        isodate : new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/)
    }
    /*eslint-enable*/
    export default {
        name: 'InputTag',

        props: {

            parent_id:{

            },
            department_parent_id:{

            },
            department_id:{

            },

            tags: {
                type: Array,
                default: () => [],
            },
            placeholder: {
                type: String,
                default: 'Add Tags',
            },
            onChange: {
                type: Function,
            },
            readOnly: {
                type: Boolean,
                default: false,
            },
            validate: {
                type: String,
                default: '',
            },

        },
        data() {
            return {
                edit: false,
                editing: false,
                newTag: '',
                files: '',
                parent_folder_id: this.parent_id,
                department_parent_folder_id: this.department_parent_id,
                description: '',
                isDepartmentFile: this.department_id,
                errors: new Errors()
            };
        },
        methods: {
            focusNewTag() {
                if (this.readOnly) { return; }
                this.$el.querySelector('.new-tag').focus();
            },
            addNew(tag) {
                if (tag && !this.tags.includes(tag) && this.validateIfNeeded(tag)) {
                    this.tags.push(tag);
                    this.tagChange();
                    console.log(this.tags.length);
                    console.log(this.tags);
                }
                this.newTag = '';
            },
            validateIfNeeded(tagValue) {
                if (this.validate === '' || this.validate === undefined) {
                    return true;
                } else if (Object.keys(validators).indexOf(this.validate) > -1) {
                    return validators[this.validate].test(tagValue);
                }
                return true;
            },
            remove(index) {
                this.tags.splice(index, 1);
                this.tagChange();
            },
            removeLastTag() {
                if (this.newTag) { return; }
                this.tags.pop();
                this.tagChange();
            },
            getPlaceholder() {
                if (!this.tags.length) {
                    return this.placeholder;
                }
                return '';
            },
            tagChange() {
                if (this.onChange) {
                    // avoid passing the observer
                    this.onChange(JSON.parse(JSON.stringify(this.tags)));
                }
            },
            addFile() {
//                let data = new FormData();
//
//                for (var i = 0; i < files.length; i++) {
//                    let file = files.item(i);
//                    data.append('images[' + i + ']', file, file.name);
//                }
//
                    console.log( this.description);
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };
                const fileInput = document.querySelector( '#files' );
                const formData = new FormData();
                for (let i = 0; i < fileInput.files.length; i++) {
                    formData.append('files[]', fileInput.files[i]);
                }
                for (let i = 0; i < this.tags.length; i++) {
                    formData.append('tags[]', this.tags[i]);
                }
                console.log(fileInput.files.length);
                formData.append('parent_folder_id', this.parent_folder_id);
                formData.append('department_parent_folder_id', this.department_parent_folder_id);
                formData.append('description', this.description);
                formData.append('isDepartmentFile', this.isDepartmentFile);
                this.edit = true;
                axios.post('/upload',formData,config)
                    .then(() => {
                        this.edit = false;
                        this.editing = true;
                        location.reload()

                    }) .catch(error => {
                    this.edit = false;
                    this.errors.record(error.response.data);
                });
            }
        },
    };
</script>



<style>

    .vue-input-tag-wrapper {
        background-color: #fff;
        border: 1px solid #ccc;
        overflow: hidden;
        padding-left: 4px;
        padding-top: 4px;
        cursor: text;
        text-align: left;
        -webkit-appearance: textfield;
    }

    .vue-input-tag-wrapper .input-tag {
        background-color: #cde69c;
        border-radius: 2px;
        border: 1px solid #a5d24a;
        color: #638421;
        display: inline-block;
        font-size: 13px;
        font-weight: 400;
        margin-bottom: 4px;
        margin-right: 4px;
        padding: 3px;
    }

    .vue-input-tag-wrapper .input-tag .remove {
        cursor: pointer;
        font-weight: bold;
        color: #638421;
    }

    .vue-input-tag-wrapper .input-tag .remove:hover {
        text-decoration: none;
    }

    .vue-input-tag-wrapper .input-tag .remove::before {
        content: " x";
    }

    .vue-input-tag-wrapper .new-tag {
        background: transparent;
        border: 0;
        color: #777;
        font-size: 13px;
        font-weight: 400;
        margin-bottom: 6px;
        margin-top: 1px;
        outline: none;
        padding: 4px;
        padding-left: 0;
        width: 80px;
    }

    .vue-input-tag-wrapper.read-only {
        cursor: default;
    }

</style>
