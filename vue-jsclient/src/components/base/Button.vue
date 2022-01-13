
<template>
        <button :class=this.getClassButton() :title=this.title>
            <slot>Button</slot>
        </button>
</template>

<script>
    export default {
        name: "my-button",
        props: {
            widthButton: {
                type: Number,
                default: 0
            },
            heightButton: {
                type: Number,
                default: 25
            },
            buttonType: {
                type: Number,
                default: 0
            },
            title: {
                type: String,
                default: "button"
            }
        },
	    created() {
		    this.CLASS_DISABLE = 'disable',
			this.CLASS_PERMANENT_OVER = 'ff-button-selected'

	    },
        mounted(){
            if(this.widthButton > 0) {
                this.$el.style.width = this.widthButton + 'px';
            }
            this.$el.style.height = this.heightButton + 'px';
        },
        methods:{
	        disable: function (dsb) {
	        	if(dsb){
			        this.$el.setAttribute('disabled',true);
			        this.$el.classList.add(this.CLASS_DISABLE);

                }else{
			        this.$el.removeAttribute ('disabled');
			        this.$el.classList.remove(this.CLASS_DISABLE);
                }

            },
            permanentOver: function (on) {
	        	if(on){
			        this.$el.classList.add(this.CLASS_PERMANENT_OVER);
                }else{
			        this.$el.classList.remove(this.CLASS_PERMANENT_OVER);
                }

            },
            getClassButton: function () {
                let returnValue = 'ff-button';

                if(this.buttonType == 1){
                    returnValue = returnValue + '-icon';

                }else if(this.buttonType == 2){
                    returnValue = returnValue + '-icon-toolbar';

                }
                return returnValue;
            }
        }
    }
</script>
<style scoped></style>
