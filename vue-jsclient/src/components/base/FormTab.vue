<template>
    <div class = 'ff-form-tab'>
        <div class = "loading-modal" v-if="this.showModalLoadingDiv">
            <div>
                <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="3x" spin/>
            </div>
        </div>

        <div class = 'form-title'>
            <slot name='slotTitle' ></slot>
        </div>
        <div class = 'form-content'>
            <slot name='slotContent' ></slot>
        </div>
        <div class = 'form-button'>
            <slot name='slotButton' ></slot>
        </div>
        <div class = 'form-bottom-line'>
        </div>
    </div>

</template>

<script>
    export default {
		name: "my-form-tab",
        components:{
        },
        props: {
        },
		directives: {},
        created() {

        },
        mounted() {
        },
        methods: {
            showModal: function (show) {
                this.showModalLoadingDiv = show;
            }
        },
		data () {
			return {
                showModalLoadingDiv: false
            }
		}
	}

</script>

<style scoped>
</style>
