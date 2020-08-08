$('#btnAddNewComm').on('click',function (e) {
    e.preventDefault();
    let form = $('#form-add-comment');
    if (valid(form)){
        ajaxAddComment(form,0);
    }
});
//function answer(){
    $('#block').on('click','.answerBtn',function(e) {
        console.log(e);
        e.preventDefault();
        let form = $(e.target.form);
        console.log(form);
        if (valid(form)){
            ajaxAddComment(form,form[0].getAttribute('data-parent_id'));
        }
    });
//}
//answer();

function valid(form) {
    if (form.find('textarea')[0].value.length > 0){
        return true;
    }else{
        form.find('div.err')[0].innerHTML = '<p style="color: red; font-size: 12px; position: absolute;">Коментарий пуст</p>';
        form.find('textarea').keypress(function () {
            form.find('div.err')[0].innerHTML = '';
        });
        return false;
    }

}
function ajaxAddComment(form,parent_id){
    let topic_id = document.querySelector('input[name=topic_id]').value;
    console.log(topic_id);
    let data = form.serialize();
    $.ajax({
        url: 'addComment.php',
        type:'GET',
        data: data + '&parent_id=' + parent_id + '&topic_id=' + topic_id,
        success:function (data) {
            $(form[0].parentNode).collapse('hide');
            let json = JSON.parse(data);
            let li = document.querySelector('.li-shab').cloneNode(true);
            li.classList.remove('li-shab');
            li.setAttribute('data-id',json.id);
            li.querySelector('.blockFoto').style.backgroundColor = json.color;
            li.querySelector('h4').innerHTML = 'Коментарий с id ' + json.id;
            li.querySelector('span').innerHTML = json.body;
            li.querySelector('.commBtn').setAttribute('data-target','#collapseBlock'+json.id);
            li.querySelector('div.collapse').setAttribute('id','collapseBlock'+json.id);
            li.querySelector('form.formAnswer').setAttribute('data-parent_id',json.id);
            let ul = document.querySelector('.comm-list');
            let ull = document.createElement('ul');
            ull.classList.add('comm-list');
            let noComm = document.getElementById('comm-none');
            if (parent_id==0){

                if (!noComm){
                    ul.appendChild(li);
                    //answer();
                }else {
                    //ull.appendChild(li);
                    noComm.parentNode.removeChild(noComm);
                    ul.appendChild(li);
                    //answer();

                }
            }else{
                ull.appendChild(li);
                console.log(ul.querySelector('li.li-sps[data-id="' + json.parent_id + '"]'));
                ul.querySelector('li.li-sps[data-id="' + json.parent_id + '"]').appendChild(ull);
                //answer();
            }
            form.trigger('reset');
        }
    });
}