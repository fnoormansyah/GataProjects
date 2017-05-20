

<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="glyphicon glyphicon-user"></i>
    <span>LOGIN <i class="caret"></i></span>
</a>
<ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header bg-light-blue">
        <br>
        <img src="img/icon_key.png" class="img-circle" alt="Key Image" />                    
        <br>
        <p><i>Please Login</i></p>    
    </li>
    <!-- Menu Body -->
    <li class="user-body">
        <div class="col-xs-12 text-info">
            <form id="frmlogin" method="post" action="index.php?model=login&action=checkLogin">
                <table width="250" cellpadding="5" cellspacing="5">
                    <tr>
                      <td valign="top">
                          <div class="form-group"> User </div>
                        </td>
                        <td width="10" valign="top">
                            :
                        </td>
                        <td>
                          <div class="form-group"> <input type="text" name="user" id="user" size="15"></div>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top">
                           <div class="form-group"> Password</div>
                        </td>
                        <td valign="top">
                            :
                        </td>
                        <td>
                            <div class="form-group"> <input type="password" name="password" id="password" size="15"></div> 
                        </td>
                  </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                        </td>
                        <td><input type="submit" value="Login" class="BtnOrange" onmouseover="this.className='BtnOrangeHov'" onmouseout="this.className='BtnOrange'" />

                        </td>
                    </tr>
                </table>                 
                  
          </form>
                        
        </div>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
        <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Forgot Password</a>
        </div>
        <div class="pull-right">
            <a href="#" class="btn btn-default btn-flat">Sign Up</a>
        </div>
    </li>
    </ul>
</li>
    