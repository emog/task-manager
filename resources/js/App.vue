<template>
    <div>
        <router-view />
    </div>
</template>
<script>
export default {
    name: 'App',
    metaInfo: {
        // if no subcomponents specify a metaInfo.title, this title will be used
        title: 'Task Manager',
        // all titles will be injected into this template
        titleTemplate: '%s'
    }
}
</script>
