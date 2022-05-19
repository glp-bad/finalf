<template>
    <div class="ff-popup" :ref=this.cfgtime.REF_ROOT>
        <div class="ff-popup-container" :ref=this.cfgtime.REF_CONTAINER>
            <div class="title" :ref=this.cfgtime.REF_TITLE>
                <span class="caption"></span>
                <div class="closeButton" @click="this.close()"><span>X</span></div>
            </div>
            <div class="content">
                <slot name='slotContent' ></slot>
            </div>
            <div class="bottom">
                <slot name='slotBottom' ></slot>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		name: "my-popup",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
        created() {
	        this.cfgtime = {
		        REF_ROOT: 'refRoot',
		        REF_CONTAINER: 'refPopUp',
		        REF_TITLE: 'refTitle'
	        },
		    this.runtime = {
	        }
        },
        mounted() {
			this.privateCfg();
        },
        methods: {
	        setWidth: function (width) {
		        let container = this.$refs[this.cfgtime.REF_CONTAINER];
		        container.style.width = width + 'px';
            },
			setCaption: function (caption) {
				let title = this.$refs[this.cfgtime.REF_TITLE];
				title.getElementsByClassName("caption")[0].innerHTML = caption;
			},
            close: function () {
	            let root = this.$refs[this.cfgtime.REF_ROOT];
	            root.style.display = 'none';
            },
	        show: function () {
		        let root = this.$refs[this.cfgtime.REF_ROOT];
		        root.style.display = 'table';
	        },
			privateCfg: function () {
				let container = this.$refs[this.cfgtime.REF_CONTAINER];



				if(this.pConfig.height == null){
					container.style.height = 'auto';
                }else{
					container.style.height = this.pConfig.height + 'px';
                }

				if(this.pConfig.width == null){
					container.style.width  = 'auto';
                }else{
					container.style.width  = this.pConfig.width + 'px';
                }


				this.setCaption(this.pConfig.title);

			}
        },
		data () {
			return {
            }
		}
	}

</script>

<style scoped>
</style>
