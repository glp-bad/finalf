<template>
    <div class = "w-login-modal">
        <div class="w-login" ref="windowRef">

            <div class="header" ref="headerRef">
                <span>Login ({{this.VERSION_APP}})</span>
            </div>

            <div class="content">

                <form @submit.prevent="logOn">
                    <table class="ff-form-table">
                        <tr>
                            <td class="label-left bold">
                                <label for="email">E-Mail Address</label></td>
                            <td class="control">
                                <input id="email" type="email" size="30" name="email" required autocomplete="email" autofocus v-model="post.email">
                            </td>
                        </tr>
                        <tr>
                            <td class="label-left bold">
                                <label for="password" >Password</label></td>
                            <td class="control">
                                <input id="password" type="password" size="30" name="password" required autocomplete="current-password" v-model="post.password">
                            </td>
                        </tr>
                        <!--
                            <tr >
                                <td colspan="2">
                                    <br>
                                    <input  type="checkbox" name="remember" id="remember" v-model="post.remember">
                                    <label  for="remember" class="label-left bold">
                                        Remember Me
                                    </label>
                                </td>
                            </tr>
                        -->
                    </table>

                    <br>
                    <div>
                        <div >
                            <my-button :type="submit">Login</my-button>
                            <span v-if="this.requestLoginFail" class="red-label"> {{this.messageFail}} </span>
                        </div>
                    </div>
                </form>


            </div>

            <div class="bottom-line">
            </div>

        </div>
    </div>
</template>

<script>

	import Button from '@/components/base/Button';

    export default {
        name: "my-login",
        components: {
        	'my-button': Button
        },
        props: {},
        created() {
	        this.EMIT = 'loginWindows',
		    this.URI  = this.$url.getUrl("login");

        },
        mounted() {
	        this.post= {email:  "...email", password: null };
	        this.$vanilla.dragDiv(this.$refs.windowRef, this.$refs.headerRef);
        },
        methods: {
            submit: function (){
                // do nothing
                // doar pentru mesajul:  [Vue warn]: Property "submit" was accessed during render but is not defined on instance
                // momentan nu am gasit alta solutie
            },
	        logOn: function (){
		        // this.$emit(this.EMIT);
                // console.log("this.URI: ", this.URI);
		        this.axios.post(this.URI, this.post).then((response) => {
				        if(response.data.succes){
					        this.login = true;
					        this.requestLoginFail = false;
				        }else{
                            this.privateSetLoginFail(response.data.messages[0]);
				        }

			            this.$emit(this.EMIT);
			        }
		        ).catch( (error) => {
		        	this.privateSetLoginFail('Refresh page and try again.');
			        this.$emit(this.EMIT);
                })
            },
            isLogOn: function () {
                return this.login;
            },
            privateSetLoginFail: function (msg) {
	            this.login = false;
	            this.requestLoginFail = true;
	            this.messageFail = msg;
            }
        },
        data() {
	        return {
		        post:{},
		        login: false,
                requestLoginFail: false,
                messageFail: 'Login fail.',
                VERSION_APP: '1.2.000'                  // from D:\bin\xampp8\htdocs\finalf\app\MyAppConstants.php
	        }
        }
    }
</script>

<style scoped></style>
