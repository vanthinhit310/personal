<template>
    <div class="main-content">
        <a-layout-content>
            <div :style="{ padding: '25px', background: '#FFF', height: 'calc(100vh - 64px)' }">
                <slot name="content"></slot>
            </div>
        </a-layout-content>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
