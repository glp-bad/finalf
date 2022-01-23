<template>
    <div class="ff-tab">
        <div class="headers">
            <ul>
                <template v-for="ph in pConfig.header">
                    <li class='header-li' >
                        <div class="header-div">
                            <a :idTab=ph.id @click="this.headerClick($event)" href="javascript:void(null);">{{ph.caption}}</a>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
        <slot name="tabs"></slot>
    </div>
</template>
<script>
	export default {
		name: "my-tab",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
		mounted() {
        },
        methods: {
            headerClick: function (event) {
                this.emitTabAction(event.target.getAttribute('idTab'));
            },
            emitTabAction:function(idTab) {
                this.$emit(this.$constTab.EMIT_TAB_ACTION, idTab);
                // console.log(this.$slots.tabs);
            },
        },
		data () {
			return {
            }
		}
	}

</script>

<style scoped>
</style>
