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

        <div :class=formClass.container :ref=CONTAINER_REF :id=cfgForm.id >
            <div :class=formClass.header ref="headerRef" >
                <span class="caption" ref="captionRef"></span>
                <div class="closeButton" @click="closeForm"><font-awesome-icon :icon="cfgForm.closeIcon" /></div>

            </div>

            <div :class=formClass.content ref="contentRef">
                <form>
                    <table class="ff-form-table">
                        <tr>
                            <td class="label bold">
                                <label :for=NUME.id>{{NUME.caption}}</label></td>
                            <td class="control">
                                <test-field
                                        :id=NUME.id
                                        :ref=NUME.ref
                                        maska=""
                                        :validate=NUME.validate
                                        :minlength = NUME.minLength
                                        :maxlength = NUME.maxLength
                                        :size = NUME.sizeField
                                ></test-field>

                            </td>

                            <td class="label bold">
                                <label :for=PRENUME.id>{{PRENUME.caption}}</label></td>
                            <td class="control">
                                <test-field
                                        :id=PRENUME.id
                                        :ref=PRENUME.ref
                                        maska=""
                                        :validate=PRENUME.validate
                                        :minlength = PRENUME.minLength
                                        :maxlength = PRENUME.maxLength
                                        :size = PRENUME.sizeField
                                ></test-field>
                            </td>

                        </tr>
                        <tr>
                            <td class="label bold">
                                <label :for=AGE.id>{{AGE.caption}}</label></td>
                            <td class="control">
                                <test-field
                                    :id=AGE.id
                                    :ref=AGE.ref
                                    maska=""
                                    :validate   = AGE.validate
                                    :minlength  = AGE.minLength
                                    :maxlength  = AGE.maxLength
                                    :size       = AGE.sizeField
                                ></test-field>
                            </td>
                            <td class="label-right bold">
                                <label :for=CONF_ACORD.id>{{CONF_ACORD.caption}}</label></td>
                            <td class="control">
                                <check-box
                                    :id=CONF_ACORD.id
                                    :ref=CONF_ACORD.ref
                                    :validate   = CONF_ACORD.validate
                                    :defaultValue = CONF_ACORD.defaultValue
                                    :size       = CONF_ACORD.sizeField
                                    :disabled = CONF_ACORD.disabled
                                ></check-box>
                            </td>

                        </tr>
                        <tr>
                            <td class="label bold">
                                <label :for=SELECT_OPTION.id>{{SELECT_OPTION.caption}}</label></td>

                            <td colspan="2" class="control">
                                <lista-numere
                                    :pId    =SELECT_OPTION.id
                                    :ref    =SELECT_OPTION.ref
                                    :pName  =SELECT_OPTION.ref
                                    :pCaptionText   ="'... alege un numar'"
                                    :pWidth         =SELECT_OPTION.width
                                    :validate   =SELECT_OPTION.validate
                                ></lista-numere>
                            </td>
                        </tr>

                    </table>
                </form>
            </div>

            <div :class=formClass.button >
                <div :class=formClass.buttonPozition  >
                    <button-send :onClick="sendData">Send data</button-send>
                </div>
            </div>

            <div :class=formClass.bottomLine ></div>

        </div>

</template>

<script>

    import TextField from '../../base/TextField.vue';
    import Button from '../../base/Button.vue';
    import AlertWindow from '../../base/AlertWindow.vue';
    import CheckBox from '../../base/CheckBox.vue';
    import DropDownSimple from '../../base/DropDownSimple.vue'

    export default {
		components: {
			'test-field': TextField,
			'check-box': CheckBox,
			'button-send': Button,
			'validate-window': AlertWindow,
            'lista-numere': DropDownSimple
		},
		name: "test-form-component",
		created() {
			    this.CONTAINER_REF = 'containerRef';
			    this.NUME       = this.cfgNume(),
				this.PRENUME    = this.cfgPreNume(),
                this.AGE        = this.cfgVarsta(),
			    this.CONF_ACORD = this.cfgConfirmareAcord(),
                this.SELECT_OPTION =  this.cfgSimpleSelect()
		},
        mounted () {
	        this.configForm();
        },
		methods: {
			closeForm: function () {
				// this.$refs[this.CONTAINER_REF].remove();
				this.$refs[this.CONTAINER_REF].style.display = "none";
			},

			showForm: function () {
				this.$refs[this.CONTAINER_REF].style.display = "table";
			},

			cfgConfirmareAcord: function(){
				let cfg = this.$app.cfgCheckBox();
				cfg.setIdAndRef("confirmare");
				cfg.validate    = this.validateConfirmare;
				cfg.caption     = "Confirm";
				cfg.defaultValue= false;
				cfg.disabled= false;

				return cfg;
            },
			cfgVarsta: function () {

				let cfg = this.$app.cfgTextFIeld();

				cfg.setIdAndRef("age");
				cfg.minLength   = 3;
				cfg.maxLength   = 3;
				cfg.validate    = this.validateAge;
				cfg.maska       = "";
				cfg.caption     = "Varsta";
				cfg.mandatory   = false;
				cfg.sizeField  = 7;

				return cfg;
			},

			cfgSimpleSelect: function () {
				let cfg = this.$app.cfgSelectSimple();
				cfg.setIdAndRef("listaNumar");
				cfg.validate    = this.validateListaNumar;
				cfg.caption     = "Lista numere";

				return cfg;
			},

			cfgNume: function () {

				let cfg = this.$app.cfgTextFIeld();
				    cfg.setIdAndRef("nume");
					cfg.minLength   = 3;
					cfg.maxLength   = 10;
					cfg.validate    = this.validateNume;
					cfg.maska       = "";
					cfg.caption     = "Nume";
					cfg.mandatory   = false;
				    cfg.sizeField  = 10;

                return cfg;
			},
			cfgPreNume: function () {

				let cfg = this.$app.cfgTextFIeld();
				cfg.setIdAndRef("prenume");
				cfg.minLength   = 4;
				cfg.maxLength   = 20;
				cfg.validate    = this.validatePreNume;
				cfg.maska       = "";
				cfg.caption     = "Prenume referinta mai mare";
				cfg.mandatory   = false;
				cfg.sizeField  = 30;

				return cfg;
			},
			configForm: function () {
				this.cfgForm.id = '777TEST'; // this.$uuid.v1();
    			this.cfgForm.closeIcon = ['fas', 'times'];
				// this.$refs.containerRef.style.width = '900px';
				//this.$refs.containerRef.style.height = '120px';
				// this.$refs.contentRef.style.width = '300px';
				//this.$refs.contentRef.style.height = '300px';
				this.$refs.captionRef.innerHTML="Introducere date de test";
				this.$vanilla.dragDiv(this.$refs.containerRef, this.$refs.headerRef);


				//console.log(document.body.firstElementChild);
				//console.log(this.$root);
				//console.log(this.$root.$children[0].$el);
				//console.log(this.$refs);

				/*
				document.getElementById('app').appendChild(
					//document.getElementById('MacGuffin')
					this.$refs.validateWindowRef
				);
				*/

				// this.$mount(this.$refs.validateWindowRef);
				//this.$root.$el.append(this.$refs.validateWindowRef);
				/*


				let div = document.body.firstElementChild;

				div.appendChild(
					//document.getElementById('MacGuffin')
					this.$refs.validateWindowRef
				);
                */



			},
            sendData: function(){
	            //this.$refs["numeRef"].validate();
	            //console.log(this.$refs["numeRef"].getValue());
	            // console.log(this.$refs);

	            //var i = "numeRef";
	            //console.log(this.$refs[i].getValue());

                this.validateForm();

                if(this.messageForm.length > 0){
	                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
	                this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.messageForm));
	                this.$refs.validateWindowRef.show();

	                return false;
                }


                    this.post.nume = this.$refs.numeRef.getValue();
	                this.post.prenume = this.$refs.prenumeRef.getValue();
	                this.post.accept = this.$refs.confirmareRef.getValue();

	                console.log("accept: " + this.post.accept);


	                let uri = this.$url.getUrl("addName");
	                this.axios
		                .post(uri, this.post)
		                .then(response => {

				                if(response.data.succes){
					                this.$refs.infoWindowRef.setCaption("Succes");
					                this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					                this.$refs.infoWindowRef.show();
                                }else{
					                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
					                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					                this.$refs.validateWindowRef.show();
                                }
			                }
		                )
		                .catch(error => {
			                    this.$refs.redWindowRef.setCaption("Probleme ... ");
			                    this.$refs.redWindowRef.setMessage(error);
			                    this.$refs.redWindowRef.show();
                            }
                        );



            },
			validateAge: function () {
				if(this.$refs[this.AGE.ref].getValue() < 5){
					this.messageForm.push(this.$app.getFormMessageClass(this.AGE.id, this.AGE.caption,
						'trebuie sa fie mai mare de cinci ani.'));
                }
			},
            validateForm: function () {
	            this.messageForm = [];
                this.$check.validateForm(this.$refs);
            },
            validateNume: function () {
				if(!this.$check.lenghtMinMax(this.$refs[this.NUME.ref].getValue(), this.NUME.minLength, this.NUME.maxLength)){
					this.messageForm.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption,
                                    'trebuie sa aiba minim ' + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"));
                }

            },
			validatePreNume: function () {
				if(!this.$check.lenghtMinMax(this.$refs[this.PRENUME.ref].getValue(), this.PRENUME.minLength, this.PRENUME.maxLength)){
					this.messageForm.push(this.$app.getFormMessageClass(this.PRENUME.id, this.PRENUME.caption,
						'trebuie sa aiba minim ' + this.PRENUME.minLength + " si maxim " + this.PRENUME.maxLength + " caractere"));
				}
			},
			validateConfirmare: function () {
			},
			validateListaNumar: function () {

				console.log('trece pe aici !!! 1000');

				let val = this.$refs[this.SELECT_OPTION.ref].getValue();
				if(val.id == 0){
					this.messageForm.push(this.$app.getFormMessageClass(this.SELECT_OPTION.id, this.SELECT_OPTION.caption,
						'trebuie sa alegi un numar din lista'));
                }
            }

		},
		data () {
			return {
				formClass: this.$css.getCss("form"),
                messageForm: [],
				post:       {nume: null, prenume: null, accept: false},
				cfgForm:    {id: null, closeIcon: ['fas', 'times']}

            }
		}
	}

</script>

<style scoped></style>
