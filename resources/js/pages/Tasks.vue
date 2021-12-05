<template>
    <div class="container">
        <h1>Tasks</h1>
        <div class="mb-5">
            <b-button variant="primary" @click="handleCreate">Add</b-button>
        </div>
        <b-table ref="table" striped hover outlined show-empty class="mb-1"
                 :responsive="true"
                 :api-url="'/api/v1/task'"
                 :items="itemsProvider"
                 :fields="fields"
        >
            <template #cell(actions)="data">
                <div class="d-flex justify-content-end">
                    <b-button @click="handleEdit(data.item)">Edit</b-button>
                </div>
            </template>
        </b-table>
        <create-update-task ref="createUpdateTaskModal" :action="createUpdateTaskAction" :task-id="createUpdateTaskId" @saveSuccess="handleSaveSuccess"/>

    </div>
</template>

<script>
import axios from "axios";
import CreateUpdateTask from "./CreateUpdateTask";

export default {
    name: "Tasks",
    components: {CreateUpdateTask},
    data() {
        return {
            fields: [
                {
                    key: 'name',
                    sortable: false
                },
                {
                    key: 'description',
                    sortable: false
                },
                {
                    key: 'created_at',
                    sortable: false
                },
                {
                    key: 'completed',
                    sortable: false,
                    formatter: value => {
                        return value ? 'Yes' : 'No'
                    }
                },
                {
                    key: 'actions',
                    sortable: false
                }
            ],
            createUpdateTaskAction: '',
            createUpdateTaskId: null
        }
    },
    mounted() {

    },
    methods: {
        itemsProvider(ctx) {

            let promise = axios.get('api/v1/task')
            return promise.then((data) => {
                const items = data.data.data
                return items
            }).catch(error => {
                // Here we could override the busy state, setting isBusy to false
                // this.isBusy = false
                // Returning an empty array, allows table to correctly handle
                // internal busy state in case of error
                return []
            })
        },
        handleCreate() {
            this.createUpdateTaskAction = 'create'
            this.createUpdateTaskId = null
            this.$nextTick(() => {
                this.$refs['createUpdateTaskModal'].show()
            })
        },
        handleEdit(task) {
            this.createUpdateTaskAction = 'update'
            this.createUpdateTaskId = task.id
            this.$nextTick(() => {
                this.$refs['createUpdateTaskModal'].show()
            })
        },
        handleSaveSuccess() {
            this.$refs.table.refresh();
        }
    }
}
</script>

<style scoped>

</style>
