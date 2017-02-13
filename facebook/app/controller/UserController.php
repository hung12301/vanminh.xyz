<?php
	class UserController extends Controller
	{
		public function index () {
			return Route::redirect('/');
		}

		public function dangnhap () {

			if(isset($_SESSION['user'])) {
				Session::setFlash('danger',"Bạn đã đăng nhập rồi");
				return Route::redirect('/');
			}

			$data['body-theme'] = 'login-page';
			$data['title'] = 'Đăng nhập';

			if(!empty($_POST)) {

	            if(!empty($_POST['email']) && !empty($_POST['password'])) {
	                
	                $email = $_POST['email'];
	                $password = md5(Config::get('password_prefix') . $_POST['password']);
	                $remember = isset($_POST['remember']) ? 1 : 0;
	                
	                if(!Validate::isEmail ($email)) {
	                    Session::setFlash('error', "Bạn phải nhập đúng định dạng Email");
	                    return Route::back();
	                }
	                
	                $User = $this->model('User');

	                if($User->select("*")->where(['email'=>$email])->count() == 0) {
	                    Session::setFlash('error', "Email này không tồn tại");
	                    return Route::back();
	                }
	                
	                if($User->login($email,$password)) {

	                	// Save into session
	                    $info = $User->select("*")->where(['email'=>$email])->first();
	                    $_SESSION['user'] = $info;

	                    // Remember Token
	                    if(isset($_POST['remember'])) {
		                	$rememberToken = createRememberToken();
		                	// Set cookie live 1 month
		                	setcookie('id', $info['id'], time() + (60 * 60 * 24 * 30), '/');
		                	setcookie('remember_token', $rememberToken, time() + (60 * 60 * 24 * 30), '/');	                	
		                	// Update remember token on server
		                	$User->update(['id'=>$info['id']], ['remember_token' => $rememberToken]);
		                } else {
		                	// Remove cookie
		                	$User->update(['id'=>$info['id']], ['remember_token' => 'no-remember']);
		                }

	                    Session::setFlash('success', "Đăng nhập thành công");
	                    return Route::redirect('/');
	                } else {
	                    Session::setFlash('error', "Sai mật khẩu");
	                    return Route::back();
	                }
	            } else {
	                Session::setFlash('error', "Bạn phải nhập đầy đủ thông tin");
	                return Route::back();
	            }
	        }

			return $this->view('/user/login', $data);
		}

		public function dangky () {

			if(isset($_SESSION['user'])) {
				Session::setFlash('danger',"Bạn đã đăng nhập rồi");
				return Route::redirect('/');
			}

			$data['body-theme'] = 'signup-page';
			$data['title'] = 'Đăng ký';

			if(!empty($_POST)) {
				if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty ($_POST['password-confirm'])) {
		        	if (strlen ($_POST['password'])<6) {
		        		Session::setFlash('error',"Mật khẩu quá ngắn");
						return Route::back();
		        	}
		            
					if ($_POST['password-confirm']!= $_POST['password']) {
						Session::setFlash('error',"Mật khẩu nhập lại không khớp");
						return Route::back();
					}

		            $name = $_POST['name'];
		            $email = $_POST['email'];
		            $password = md5(Config::get('password_prefix') . $_POST['password']);
		            
		            if(!Validate::isEmail($email)) {
		                Session::setFlash('error',"Bạn phải nhập đúng định dạng Email");
		                return Route::back();
		            }
		            
		            if(!Validate::isCharacter($name)) {
		                Session::setFlash('error', "Yêu cầu nhập đúng tên dạng \"Trần Văn A\" hoặc \"Văn A\"");
		                return Route::back();
		            }
		            
		            $User = $this->model('User');
		            $count = $User->select("*")->where(['email'=>$email])->count();
		            
		            if($count > 0) {
		                Session::setFlash('error',"Email này đã tồn tại");
		            } else {
		            	
		                $User->insert([
		                	'password' => $password,
		                	'name' => $name,
		                	'email' => $email,
		                	'avatar' => 'user.png',
		                	'license' => time() + 7 * 24 * 60 * 60
		                ]);

		                $info = $User->select("*")->where(['email'=>$email])->first();
		                $_SESSION['user'] = $info;

		                Session::setFlash('success',"Bạn đã đăng ký thành công");
		                return Route::redirect('/');
		            }
		        } else {
		        	$data['info'] = $_POST;
		        	Session::setFlash('error',"Bạn phải điền đầy đủ thông tin");
		        	return $this->view('/user/register', $data);
		        }
			}

			return $this->view('/user/register', $data);
		}

		public function dangxuat () {
			$User = $this->model("User");
			$User->update(['id'=>$_SESSION['user']['id']], ['remember_token'=>'log-out']);
			unset($_SESSION['user']);
	        Session::setFlash('success', "Đăng xuất thành công");
	        return Route::back();
		}
	}
?>