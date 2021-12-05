<template>
    <div>
        <b-modal
            ref="modal"
            no-close-on-esc
            no-close-on-backdrop
            size="lg"
            :title="modalTitle"
        >
            <b-overlay :show="form.busy || formDataIsLoading" spinner-variant="primary">
                <b-form @submit.prevent="handleSave" @keydown="form.onKeydown($event)">
                    <b-row>
                        <b-col sm="12">
                            <b-form-group
                                label="Name *"
                                label-for="name"
                                :class="{'is-invalid':form.errors.has('name')}"
                            >
                                <b-form-input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    :state="form.errors.has('name') ? false : null"
                                />
                                <b-form-invalid-feedback :state="form.errors.has('name') ? false : null">
                                    {{ form.errors.get('name') }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="mb-2 mt-2">
                        <b-col sm="12">
                            <b-form-group
                                label="Description"
                                label-for="name"
                                :class="{'is-invalid':form.errors.has('description')}"
                            >
                                <b-textarea
                                    id="name"
                                    v-model="form.description"
                                    rows="3"
                                    max-rows="6"
                                    :state="form.errors.has('description') ? false : null"
                                />
                                <b-form-invalid-feedback :state="form.errors.has('description') ? false : null">
                                    {{ form.errors.get('description') }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12">
                            <b-form-group
                                label="Completed"
                                label-for="completed"
                                :class="{'is-invalid':form.errors.has('completed')}"
                            >
                                <b-form-checkbox
                                    id="completed"
                                    v-model="form.completed"
                                    name="completed"
                                    :state="form.errors.has('completed') ? false : null"
                                />
                                <b-form-invalid-feedback :state="form.errors.has('completed') ? false : null">
                                    {{ form.errors.get('completed') }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-form>
            </b-overlay>
            <template #modal-footer>
                <b-overlay :show="form.busy || formDataIsLoading">
                    <b-button
                        id="save-button"
                        variant="primary"
                        class="mr-1"
                        :disabled="form.busy || formDataIsLoading"
                        @click="handleSave"
                    >
                        {{ btnCreateUpdateLabel }}
                    </b-button>
                </b-overlay>
                <b-button
                    id="cancel-button"
                    variant="outline-primary"
                    class=""
                    @click="handleCancel"
                >
                    Cancel
                </b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
import Form from 'vform'

export default {
    name: 'CreateUpdateTask',
    props: {
        action: {
            required: false,
            default: function () {
                return ''
            }
        },
        taskId: {
            required: false,
            default: function () {
                return null
            }
        }
    },
    data() {
        return {
            form: new Form({
                name: '',
                description: '',
                completed: false
            }),
            formDataIsLoading: false,
        }
    },
    computed: {
        modalTitle: function () {
            if (this.action === 'create') {
                return 'Create Task'
            } else if (this.action === 'update') {
                return 'Update Task'
            }
            return ''
        },
        btnCreateUpdateLabel:function (){
            if (this.action === 'create') {
                return 'Create'
            } else if (this.action === 'update') {
                return 'Save'
            }
            return ''
        }
    },
    methods: {
        reset() {
            this.form.clear()
            this.form.reset()
        },
        show() {
            this.reset()
            this.formDataIsLoading = true
            const vue = this
            if (this.taskId) {
                axios.get('api/v1/task/' + this.taskId).then(response => {
                    this.formDataIsLoading = false
                    this.form.name = response.data.data.name
                    this.form.description = response.data.data.description
                    this.form.completed = response.data.data.completed
                })
            } else {
                this.formDataIsLoading = false
            }
            this.$refs['modal'].show()
        },
        hide() {
            this.$refs['modal'].hide()
        },
        handleSave() {
            this.form.clear()
            if (!this.form.errors.any()) {
                if (this.action === 'create') {
                    return this.form
                        .post('/api/v1/task')
                        .then(response => {
                            this.$emit('saveSuccess')
                            this.hide()
                        })
                        .catch(error => {
                        })
                } else if (this.action === 'update') {
                    return this.form
                        .put('/api/v1/task/' + this.taskId)
                        .then(response => {
                            this.$emit('saveSuccess')
                            this.hide()
                        })
                        .catch(error => {
                        })
                }
            }
        },
        handleCancel() {
            this.hide()
        }
    }
}
</script>

<style scoped>

</style>
