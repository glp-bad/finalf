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

            <div class="ff-flex-form-center-align">
                <div class="item-inline">
                    <div class="label">
                        <label :for=this.cfgtime.INPUT_PRODUCT_NAME.id>{{this.cfgtime.INPUT_PRODUCT_NAME.caption}}</label>
                    </div>
                    <div class="control">
                        <input-field
                                :pConfig = this.cfgtime.INPUT_PRODUCT_NAME
                                :ref = this.cfgtime.INPUT_PRODUCT_NAME.ref
                        ></input-field>
                    </div>

                    <div class="control">
                        <div class="buttons-left">
                            <my-button :ref=this.cfgtime.REF_BUTTON_SAVE_EXPENSE @click="this.actionButton" :heightButton=22 :buttonType=0 title="denumire produs">{{this.captionButton}}</my-button>
                        </div>
                    </div>


                </div>

            </div>

            <my-list
                    :ref = this.cfgtime.PRODUCT_LIST.ref
                    :pConfig=this.cfgtime.PRODUCT_LIST
                    @emitListRowSelection = 'emitListRowSelection'
            ></my-list>
        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow from "@/components/base/AlertWindow.vue";
    import FormTab from "@/components/base/FormTab.vue";
    import Lista   from "@/components/base/Lista";
    import InputField from "@/components/base/InputField.vue";
    import Button           from "@/components/base/Button";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
	        'my-list': Lista,
	        'input-field': InputField,
	        'my-button': Button
        },
        name: "form-new=product",
        created() {
            this.REF_FORM = 'refFormNewProduct';
            this.cfgtime = {
            	URL_INSERT_PRODUCT_NAME: this.$url.getUrl('insertNewProduct'),
	            URL_UPDATE_PRODUCT_NAME: this.$url.getUrl('updateProductName'),
	            INPUT_PRODUCT_NAME: this.cfgProductName(),
	            PRODUCT_LIST : {
		            ref: 'refDetailList',
		            header: [
			            this.$constList.getHeader(1, 'Nume produs'      ,700    ,'product_name'           , this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_LEFT  )


			            // this.$constList.getHeader(20, 'Action'       ,100    ,'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
		            ],
		            recordActionButon: [
			            // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
			            // this.$constList.getActionButton(5, 'adresa implicita', 'emitAdresaImplicita', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('ro', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
			            // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
		            ],
		            cfg: { urlData: 'allProductsList', loadOnCreate: false,
			            filedNameForCheckBox: 'activ',
			            headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
			            emitListRowSelection: 'emitListRowSelection',
			            heightList: 700
		            }
	            }
            },
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
        	actionButton: function () {
              if(this.runtime.mode == this.$constFROM.MODE_NEW){
              	    this.serverSave();
              } else {
	              this.serverUpdate();
              }
	        },
	        serverUpdate: function () {
		        if(this.validateForm()){
			        this.$refs.validateWindowRef.show();
			        return false;
		        }


		        if(!this.runtime.sendDataToServer) {
			        this.runtime.yesNoMethod = 'serverUpdate';
			        this.$refs.refYesNo.setCaption("Modific");
			        this.$refs.refYesNo.setMessage("Modific denumirea ? <br> Toate produsele vor prelua noua denumire.");
			        this.$refs.refYesNo.show();
		        }



		        if(this.runtime.sendDataToServer) {
			        this.runtime.sendDataToServer = false;

			        this.$refs[this.REF_FORM].showModal(true);

			        this.axios
				        .post(this.cfgtime.URL_UPDATE_PRODUCT_NAME, this.runtime.post)
				        .then(response => {
					        if (response.data.succes) {
						        //this.getDataPartener(this.post.idPk);
						        //this.$refs.infoWindowRef.setCaption("Succes");
						        //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        //this.$refs.infoWindowRef.show();
					        }
					        else {
						        this.$refs.validateWindowRef.setCaption("Produsul nu poate fi inregistrat");
						        this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        this.$refs.validateWindowRef.show();
					        }

				        })
				        .catch(error => console.log(error))
				        .finally(() => {
					        this.refreshListProducts();
					        this.$refs[this.REF_FORM].showModal(false);
				        });
		        }

	        },
	        serverSave: function () {
		        if(this.validateForm()){
			        this.$refs.validateWindowRef.show();
			        return false;
		        }

		        this.$refs[this.REF_FORM].showModal(true);

		        this.axios
			        .post(this.cfgtime.URL_INSERT_PRODUCT_NAME, this.runtime.post)
			        .then(response => {
				        if (response.data.succes){
					        //this.getDataPartener(this.post.idPk);
					        //this.$refs.infoWindowRef.setCaption("Succes");
					        //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					        //this.$refs.infoWindowRef.show();
				        }
				        else {
					        this.$refs.validateWindowRef.setCaption("Produsul nu poate fi inregistrat");
					        this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					        this.$refs.validateWindowRef.show();
				        }

			        })
			        .catch(error => console.log(error))
			        .finally(() => {
				        this.refreshListProducts();
				        this.$refs[this.REF_FORM].showModal(false);
			        });

	        },
	        setModeForm: function (mode){
	            this.runtime.mode = mode;

	            if(this.runtime.mode == this.$constFROM.MODE_NEW){
                    this.captionButton = 'Inregistrez';
                    this.$refs[this.cfgtime.INPUT_PRODUCT_NAME.ref].setValue('');
                }else if(this.runtime.mode == this.$constFROM.MODE_EDIT){
		            this.captionButton = 'Modific';
                }

            },
	        refreshListProducts: function () {
		        this.$refs[this.cfgtime.PRODUCT_LIST.ref].showList();
		        this.setModeForm(this.$constFROM.MODE_NEW);
	        },
	        emitListRowSelection: function (target) {
		        let tr = target.closest('tr');
		        this.runtime.post.idPk = tr.getAttribute('idPk');
		        this.$refs[this.cfgtime.INPUT_PRODUCT_NAME.ref].setValue(tr.outerText);

		        this.setModeForm(this.$constFROM.MODE_EDIT);
	        },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this[this.runtime.yesNoMethod].apply();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
            validateForm: function () {
	            let returnValidate = false;
	            this.runtime.validateMessage = [];

	            this.$check.validateForm([this.$refs[this.cfgtime.INPUT_PRODUCT_NAME.ref]]);
	            if( this.runtime.validateMessage.length>0 ){
		            this.$refs.validateWindowRef.setCaption("Articolul nu poate fi inregistrat");
		            this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.validateMessage));
		            returnValidate = true;
	            }

	            return returnValidate;
            },
	        validateProductName: function () {

		        let control = this.cfgtime.INPUT_PRODUCT_NAME;
		        let value = this.$refs[control.ref].getValue();

		        if(!this.$check.lenghtMinMax(value, control.minLength, control.maxLength)){
			        this.runtime.validateMessage.push(this.$app.getFormMessageClass(control.id, control.caption,
				        'trebuie sa aiba minim ' + control.minLength + " si maxim " + control.maxLength + " caractere"));
		        }

		        this.setPost(control, value);
	        },
	        cfgProductName: function(){
		        let cfg = this.$app.cfgInputField("product_name", 0, 500);
		        cfg.setValidate(2,200);
		        cfg.setValidateFunction(this.validateProductName);
		        cfg.setCaption("Produs");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        }

        },
        data () {
            return {
	            captionButton: 'Inregistrez'
            }
        }
    }

</script>

<style scoped></style>
