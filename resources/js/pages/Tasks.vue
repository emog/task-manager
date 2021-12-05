<template>
    <h1>Tasks</h1>
</template>

<script>
import axios from "axios";
export default {
    name: "Tasks",
    mounted() {
        axios.get('api/v1/task')
    }
}
</script>

<style scoped>

</style>
