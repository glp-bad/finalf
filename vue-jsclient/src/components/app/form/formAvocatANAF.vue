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

    <validate-window ref="refYesNoInsert"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonInsert"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>

            <table class="ff-form-table">
                <tr>
                    <td class="control">
                        <div class="buttons">
                            &nbsp;
                            <my-button :ref=this.cfgtime.REF_BUTTON_TEST_OAUTH @click="this.privateTestOauth" :heightButton=22 :buttonType=0 title="test OAUTH">Test OAUTH</my-button>
                        </div>
                    </td>
                </tr>    
            </table>

        </template>
        <template v-slot:slotButton>
        </template>


    </form-tab>
</template>

<script>
    import AlertWindow  from "@/components/base/AlertWindow.vue";
    import FormTab      from "@/components/base/FormTab.vue";
    import Button       from "@/components/base/Button";
    import InputField   from "@/components/base/InputField.vue";
import DropDownSearch from "@/components/base/DropDownSearch.vue";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-button': Button,

            'input-field': InputField
        },
        name: "form-avocat-anaf",
        created() {
            this.REF_FORM = 'refFormAnaf';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
                message: [],
                post: { idPk: null, field: {}, sqlAction: null},
	            postInsert: { idPk: null, field: {}, sqlAction: null},
                yearList: 0
            };
            this.cfgtime = {
                REF_BUTTON_TEST_OAUTH: 'refButtonTestOauth',
                URL_TEST_OATH: this.$url.getUrl('testOauth'),
            };

        },
        mounted () {
        },
        methods: {
            privateTestOauth(){
                this.$refs[this.REF_FORM].showModal(true);

                this.axios.post(this.cfgtime.URL_TEST_OATH, this.runtime.post)
                    .then((response) => {

                                    this.$refs.validateWindowRef.setCaption("Test OAUTH");
                                    this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                    this.$refs.validateWindowRef.show();

                    }).finally(() => {
                    this.$refs[this.REF_FORM].showModal(false);
                });
            }
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
