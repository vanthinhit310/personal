<template>
    <div class="main-content">
        <a-layout-content :style="{ margin: '15px 15px 0' }">
            <div :style="{ padding: '15px', background: '#fff', minHeight: 'calc(100vh - 120px)' }">
                <slot name="content"></slot>
            </div>
        </a-layout-content>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
