
<article>
    <div class="form_box">
        <form id="myform" role="form">
            <div class="form-row">
            <div class="col-lg-6">
                <div class="col-12 in_name">
                    <h4>公司名稱</h4>
                    <input type="text" class="form-control" id="inputCompany" >
                </div>
                <div class="col-12">
                    <label for="name"><b>*</b>姓名</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="help-block"></div>
                </div>
                <div class="col-12 rad_box">
                    <label for="gender"><b>*</b>性別</label>
                    <div class="rad_content">
                        <div class="radio">
                            <input type="radio" class="form-control" id="c_1" name="gender" required>
                            <label for="c_1">男</label>
                        </div>
                        <div class="radio">
                            <input type="radio" id="c_2" name="gender" required>
                            <label for="c_2">女</label>
                        </div>                        
                    </div>
                    <div class="help-block"></div>
                </div>
                <div class="col-12">
                    <label for="tel"><b>*</b>電話</label>
                    <input type="tel" class="form-control" id="tel" name="tel" required>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-12">
                    <label for="email"><b>*</b>電子信箱</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="help-block"></div>
                </div>
                <div class="col-12 textarea_form">
                    <label for="textarea"><b>*</b>訊息內容</label>
                    <textarea id="textarea" class="form-control" name="textarea" rows="5"  placeholder="內容"  required></textarea>
                    <div class="help-block"></div>
                </div>
            </div>
            </div>
            <div class="form_btn">
                <button class="submit" type="submit">確認送出</button>
            </div>
        </form>
    </div>
</article>