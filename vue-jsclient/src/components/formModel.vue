<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow from "@/components/base/AlertWindow.vue";
    import FormTab from "@/components/base/FormTab.vue";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow
        },
        name: "form-xxxxxxx",
        created() {
            this.REF_FORM = 'refFormModel';
            this.cfgtime = {},
            this.runtime = {
	            mode: this.$constFROM.MODE_NEW,
	            validateMessage: [],
                sendDataToServer: false,
                yesNoMethod: 'methodName',
                post: { idPk: null, field: {}, sqlAction: null}
            }
        },
        emits: ['emitModel'],
        mounted () {
        },
        methods: {
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this[this.runtime.yesNoMethod].apply();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
	        setModeForm: function (mode){
		        this.runtime.mode = mode;
	        },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
	        validateForm: function () {
		        let returnValidate = false;
		        this.runtime.validateMessage = [];
		        this.$check.validateForm(this.$refs);

		        if( this.runtime.validateMessage.length>0 ){
			        this.$refs.validateWindowRef.setCaption("XXXXX nu poate fi acceptat");
			        this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.validateMessage));
			        returnValidate = true;
		        }

		        return returnValidate;
	        }
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
