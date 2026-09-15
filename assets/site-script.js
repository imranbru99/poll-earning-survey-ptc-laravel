// $(function() {
//    var $questionIndex=("#questionIndex").text();
//     alert("questionIndex="+$questionIndex);
// });
$(function() {
    /* surveyTbl */

    // $(".surveyTbl").dataTable();

    /* Dunamic Add Question */
    var max_fields = 16; //maximum input boxes allowed
    var questionCountIndex = 0; //maximum input boxes allowed
    var additionalQuestions = $(".questionWrapperhold");
    var addMultichoiceQbtn = $(".addMultichoiceQbtn");
    var addInputBasebtn = $(".addInputBasebtn");
    var addYesNoQbtn = $(".addYesNoQbtn");
    var addLinearQbtn = $(".addLinearQbtn");
    var addDropDownQbtn = $(".addDropDownQbtn");
    var addImageBaseQbtn = $(".addImageBaseQbtn");
    var addIqQuestionbtn = $(".addIqQuestionbtn");
    var addCheckBoxQuestion = $(".addCheckBoxQuestion");
    var addVideoBaseQbtn = $(".addVideoBaseQbtn");

    const VideoBase =
        '<div class="addtionalQstns"><div class="col-auto questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">' +
        "Username" +
        '</label><div class="input-group mb-2">' +
        '<input required class="form-control" id="inlineFormInputGroup" name="VideoBase[questions][lists][]" placeholder="input Video Base question here" type="text"/></div>' +
        '<div class="input-group mb-2"><div class="card card-body">' +
        '<div class="row"><div class="col-12 d-flex">' +
        '<div class="custom-file">' +
        '<label class="label--text">Video Link</label></div></div>' +
        '<textarea required  name="link" placeholder="Provide Embed link, Likewise: youtube.com/embed/Idjk6t0fIHs" ></textarea>' +
        '<div class="card card-body"><div class="row">' +
        '<div class="col-6 d-flex"><label for="optionA">Option A' +
        '<input type="text" name="VideoBase[questions][options][A][]" class="form-control" required></label>' +
        '<label for="answerOptionA" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="VideoBase[questions][answers][optionA][]" class="form-control" >' +
        '</label></div><div class="col-6 d-flex"><label for="optionA">Option B' +
        '<input type="text" name="VideoBase[questions][options][B][]" class="form-control" required></label>' +
        '<label for="answerOptionB" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="VideoBase[questions][answers][optionB][]" class="form-control"></label>' +
        '</div><div class="col-6 d-flex"><label for="optionC">Option C' +
        '<input type="text" name="VideoBase[questions][options][C][]" class="form-control" required></label>' +
        '<label for="answerOptionC" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="VideoBase[questions][answers][optionC][]" class="form-control"></label>' +
        '</div><div class="col-6 d-flex">' +
        '<label for="optionD">Option D' +
        '<input type="text" name="VideoBase[questions][options][D][]" class="form-control" required></label>' +
        '<label for="answerOptionD" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="VideoBase[questions][answers][optionD][]" class="form-control"></label>' +
        '</div></div></div> </div> </div></div><div class="remove_field btn btn-danger" style="cursor:pointer;">Remove</div></div>';

    const imageBaseQuestion =
        '<div class="addtionalQstns">' +
        '<div class="col-auto questionHolders mt-3">' +
        '<label class="sr-only" for="inlineFormInputGroup">' +
        "Username" +
        '</label><div class="input-group mb-2">' +
        '<input required class="form-control" id="inlineFormInputGroup" name="imageBaseQuestions[questions][lists][]" placeholder="input image Base Question here" type="text"/>' +
        '</div>' +
        '<div class="input-group mb-2">' +
        '<div class="card card-body">' +
        '<div class="row">' +
        '<div class="col-12 d-flex">' +
        '<div class="custom-file">' +
        '<input type="file" required class="custom-file-input" name="image" id="customFile">' +
        '<label class="custom-file-label" for="customFile">Choose file</label>' +
        '</div></div>' +
        '<div class="card card-body">' +
        '<div class="row">' +
        '<div class="col-6 d-flex">' +
        '<label for="optionA">Option A' +
        '<input type="text" name="imageBaseQuestions[questions][options][A][]" class="form-control" required>' +
        '</label><label for="answerOptionA" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="imageBaseQuestions[questions][answers][optionA][]" class="form-control">' +
        '</label></div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionA">Option B' +
        '<input type="text" name="imageBaseQuestions[questions][options][B][]" class="form-control" required>' +
        '</label>' +
        '<label for="answerOptionB" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="imageBaseQuestions[questions][answers][optionB][]" class="form-control">' +
        '</label>' +
        '</div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionC">Option C' +
        '<input type="text" name="imageBaseQuestions[questions][options][C][]" class="form-control" required>' +
        '</label>' +
        '<label for="answerOptionC" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="imageBaseQuestions[questions][answers][optionC][]" class="form-control">' +
        '</label></div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionD">Option D' +
        '<input type="text" name="imageBaseQuestions[questions][options][D][]" class="form-control" required>' +
        '</label>' +
        '<label for="answerOptionD" class="mt-3 ml-1">Is answer' +
        '<input type="checkbox" name="imageBaseQuestions[questions][answers][optionD][]" class="form-control">' +
        '</label>' +
        '</div></div></div> </div> ' +
        '</div></div>' +
        '<div class="remove_field btn btn-danger" style="cursor:pointer;">Remove</div></div>';

    const MultichoiceQuestion =
        '<div class="addtionalQstns">' +
        '<div class="col-auto questionHolders mt-3">' +
        '<label class="sr-only" for="inlineFormInputGroup">Username' +
        '</label>' +
        '<div class="input-group mb-2">' +
        '<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="input Multichoice Question here" required name="MultiChoiceQuestions[questions][lists][]">' +
        '</div>' +
        '<div class="card card-body">' +
        '<div class="row">' +
        '<div class="col-6 d-flex">' +
        '<label for="optionA">Option A ' +
        '<input type="text"  name="MultiChoiceQuestions[questions][options][A][]" class="form-control" required>' +
        '</label>' +
        '<div class="col-5 mt-2">' +
        '<label for="answerOptionA">Is answer ' +
        '<input value=1 id="a" onclick="valueChanged(this.id)" type="radio" name="MultiChoiceQuestions[questions][answers][optionA][]" class="form-control">' +
        '</label></div></div>' +
        '<div class="col-6 d-flex"><label for="optionB">Option B' +
        '<input type="text" name="MultiChoiceQuestions[questions][options][B][]" class="form-control" required>' +
        '</label><div class="col-5 mt-2">' +
        '<label for="answerOptionB">Is answer ' +
        '<input value=1 id="b" onclick="valueChanged(this.id)" type="radio" name="MultiChoiceQuestions[questions][answers][optionB][]" class="form-control">' +
        '</label></div>' +
        '</div>' +
        '<div class="col-6 d-flex"><label for="optionC">Option C ' +
        '<input type="text" name="MultiChoiceQuestions[questions][options][C][]" class="form-control" required>' +
        '</label><div class="col-5 mt-2">' +
        '<label for="answerOptionC">Is answer ' +
        '<input value=1 id="c" onclick="valueChanged(this.id)" type="radio" name="MultiChoiceQuestions[questions][answers][optionC][]" class="form-control">' +
        '</label></div></div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionD">Option D' +
        '<input type="text" name="MultiChoiceQuestions[questions][options][D][]" class="form-control" required>' +
        '</label><div class="col-5 mt-2">' +
        '<label for="answerOptionD">Is answer ' +
        '<input value=1 id="d" onclick="valueChanged(this.id)" type="radio" name="MultiChoiceQuestions[questions][answers][optionD][]" class="form-control">' +
        '</label></div></div></div></div>' +
        '<div style="cursor:pointer;" class="remove_field btn btn-danger">Remove</div></div></div></div>';

    const InputBaseType =
        '<div class="addtionalQstns"><div class="col-auto questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">' +
        "Username" +
        '</label><div class="input-group mb-2"><input required class="form-control" id="inlineFormInputGroup" name="InputBaseQuestions[questions][lists][]" placeholder="input question here" type="text"/></div><div class="remove_field btn btn-danger" style="cursor:pointer;">Remove</div></div></div>';

    const YesNoQuestion =
        '<div class="addtionalQstns"><div class="col-12 questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">' +
        "Username" +
        '</label><div class="mb-2 col-12"><input required class="form-control" id="inlineFormInputGroup" name="YesNoQuestions[questions][lists][]" placeholder="input question here" type="text"/><div class="card card-body"><div class="row"><div class="col-6 d-flex"><label for="optionA">Yes Option <input required type="text" name="YesNoQuestions[questions][options][YesOptions][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionYes">Is answer <input type="checkbox" name="YesNoQuestions[questions][answers][Yesanswer][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionB">No Option <input required type="text" name="YesNoQuestions[questions][options][NoOptions][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionB">Is answer <input type="checkbox" name="YesNoQuestions[questions][answers][Noanswer][]" class="form-control"></label></div></div></div></div><div class="remove_field btn btn-danger" style="cursor:pointer;">Remove</div></div>';

    const LinearQuestion =
        '<div class="addtionalQstns"><div class="col-auto questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">' +
        "Username" +
        '</label><div class="input-group mb-2"><input class="form-control" id="inlineFormInputGroup" name="LinearQuestions[questions][lists][]" required placeholder="input question here" type="text"/></div><div class="input-group mb-2"><div class="card card-body"><div class="row"><div class="col-6 d-flex"><label for="minVal">Minimum Value <input class="form-control" required name="LinearQuestions[questions][options][minVal][]" type="text"/></label></div><div class="col-6 d-flex"><label for="optionB"> Maximum Value <input required class="form-control" name="LinearQuestions[questions][options][maxVal][]" type="text"/></label> </div> </div> </div></div><div class="remove_field btn btn-danger" style="cursor:pointer;">Remove</div></div>';

    const dropDownQuestion =
        '<div class="addtionalQstns"><div class="col-auto questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">Username</label><div class="input-group mb-2"><input type="text" class="form-control" id="inlineFormInputGroup" placeholder="DROP DOWN SELECT FORM QUESTION: input qustion here" required name="dropDownQuestions[questions][lists][]"></div><div class="card card-body"><div class="row"><div class="col-6 d-flex"><label for="optionA">Option A <input type="text"  name="dropDownQuestions[questions][options][A][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionA">Is answer <input value=1 type="checkbox" name="dropDownQuestions[questions][answers][optionA][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionB">Option B<input type="text" name="dropDownQuestions[questions][options][B][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionB">Is answer <input value=1 type="checkbox" name="dropDownQuestions[questions][answers][optionB][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionC">Option C <input type="text" name="dropDownQuestions[questions][options][C][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionC">Is answer <input value=1 type="checkbox" name="dropDownQuestions[questions][answers][optionC][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionD">Option D<input type="text" name="dropDownQuestions[questions][options][D][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionD">Is answer <input value=1 type="checkbox" name="dropDownQuestions[questions][answers][optionD][]" class="form-control"></label></div></div></div></div><div style="cursor:pointer;" class="remove_field btn btn-danger">Remove</div></div></div></div>';

    const IqQuestionbtn =
        '<div class="addtionalQstns">' +
        '<div class="col-auto questionHolders mt-3">' +
        '<label class="sr-only" for="inlineFormInputGroup">Username</label>' +
        '<div class="input-group mb-2">' +
        '<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="input IQ Question with Fixed answer here" required name="IqQuestionbtn[questions][lists][]" required>' +
        '</div>' +
        '<div class="card card-body">' +
        '<div class="row">' +
        '<div class="col-6 d-flex">' +
        '<label for="optionA">Option A ' +
        '<input type="text"  name="IqQuestionbtn[questions][options][A][]" class="form-control" required>' +
        '</label>' +
        '<div class="col-5 mt-2">' +
        '<label for="answerOptionA">Is answer ' +
        '<input value=1 type="radio" required="" onclick="valueChanged(this.id)" id="a" name="IqQuestionbtn[questions][answers][optionA][]" class="form-control ReqForA"  >' +
        '</label>' +
        '</div>' +
        '</div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionB">Option B' +
        '<input type="text" name="IqQuestionbtn[questions][options][B][]" class="form-control" required>' +
        '</label>' +
        '<div class="col-5 mt-2">' +
        '<label for="answerOptionB" >Is answer ' +
        '<input value=1 type="radio" required="" id="b" onclick="valueChanged(this.id)" name="IqQuestionbtn[questions][answers][optionB][]" class="form-control ReqForB" >' +
        '</label>' +
        '</div>' +
        '</div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionC">Option C ' +
        '<input type="text" name="IqQuestionbtn[questions][options][C][]" class="form-control" required>' +
        '</label>' +
        '<div class="col-5 mt-2">' +
        '<label for="answerOptionC" >Is answer ' +
        '<input value=1 type="radio" required="" id="c" onclick="valueChanged(this.id)" name="IqQuestionbtn[questions][answers][optionC][]" class="form-control ReqForC" >' +
        '</label>' +
        '</div>' +
        '</div>' +
        '<div class="col-6 d-flex">' +
        '<label for="optionD">Option D' +
        '<input type="text" name="IqQuestionbtn[questions][options][D][]" class="form-control" required>' +
        '</label>' +
        '<div class="col-5 mt-2">' +
        '<label for="answerOptionD" >Is answer ' +
        '<input value=1 type="radio" required="" id="d" onclick="valueChanged(this.id)" name="IqQuestionbtn[questions][answers][optionD][]" class="form-control ReqForD">' +
        '</label>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div style="cursor:pointer;" class="remove_field btn btn-danger">Remove' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    const CheckBoxQuestion =
        '<div class="addtionalQstns"><div class="col-auto questionHolders mt-3"><label class="sr-only" for="inlineFormInputGroup">Username</label><div class="input-group mb-2"><input type="text" class="form-control" id="inlineFormInputGroup" placeholder="input qustion here" required name="MultiChoiceQuestions[questions][lists][]"></div><div class="card card-body"><div class="row"><div class="col-6 d-flex"><label for="optionA">Option A <input type="text"  name="MultiChoiceQuestions[questions][options][A][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionA">Is answer <input value=1 type="checkbox" name="MultiChoiceQuestions[questions][answers][optionA][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionB">Option B<input type="text" name="MultiChoiceQuestions[questions][options][B][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionB">Is answer <input value=1 type="checkbox" name="MultiChoiceQuestions[questions][answers][optionB][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionC">Option C <input type="text" name="MultiChoiceQuestions[questions][options][C][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionC">Is answer <input value=1 type="checkbox" name="MultiChoiceQuestions[questions][answers][optionC][]" class="form-control"></label></div></div><div class="col-6 d-flex"><label for="optionD">Option D<input type="text" name="MultiChoiceQuestions[questions][options][D][]" class="form-control" required></label><div class="col-5 mt-2"><label for="answerOptionD">Is answer <input value=1 type="checkbox" name="MultiChoiceQuestions[questions][answers][optionD][]" class="form-control"></label></div></div></div></div><div style="cursor:pointer;" class="remove_field btn btn-danger">Remove</div></div></div></div>';

    var x = 1; //initlal text box count
    $(addMultichoiceQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(MultichoiceQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });
    $(addVideoBaseQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(VideoBase);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });

    $(addIqQuestionbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(IqQuestionbtn);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });
    // CheckBoxQuestion
    $(addCheckBoxQuestion).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(CheckBoxQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });
    $(addInputBasebtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(InputBaseType);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });

    $(addDropDownQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(dropDownQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });

    $(addYesNoQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(YesNoQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });

    $(addLinearQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(LinearQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });

    $(addImageBaseQbtn).click(function(e) {
        //on add input button click
        e.preventDefault();
        if (x < max_fields) {
            //max input box allowed
            x++; //text box increment
            questionCountIndex++; //text box increment
            $("#questionIndex").html(questionCountIndex);
            $(additionalQuestions).append(imageBaseQuestion);
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        }
    });


    /* Remove Input fields*/
    $(additionalQuestions).on("click", ".remove_field", function(e) {
        //user click on remove text
        e.preventDefault();
        $(this).parent("div").remove();
        x--;
        questionCountIndex--;
        if ($(".form-control").length) {
            // alert("The element you're testing is present.");
            if ($(".saveQuestionsNow").prop("disabled", "disabled")) {
                $(".saveQuestionsNow").prop("disabled", false);
            } else {
                $(".saveQuestionsNow").prop("disabled", true);
            }
        } else {
            $(".saveQuestionsNow").prop("disabled", true);
        }
    });
});

/*
$(document).on('click', '.saveQuestionsNow', function (e) {
      e.preventDefault();
      let fd = new FormData();


      // var axiosproducturl = '/admin/dashboard/products/add-new-product';


      $("input[name='MultiChoiceQuestions'").map(function (i, el) {
        if (i != 'undefined') {
          return fd.append('MultiChoiceQuestions[]', $(el).val);
        }
      });
      $("#sizes :selected").map(function (i, el) {
        if (i != 'undefined') {
          return fd.append('sizes[]', $(el).attr('id'));
        }
      });

      var category = $('select[name=category]').val();
      var stockstatus = $('select[name=stockstatus]').val();

      if ($("#discount").val() != '') {
        fd.append('discount', discount);
      }
      if ($("#productImage").length) {
        var productImage = document.querySelector('#productImage').files[0];
        fd.append('productImage', productImage);
      }
      fd.append('cost_price', cost_price);
      fd.append('price', price);
});
*/


function valueChanged(para) {
    var va = document.getElementById(para);
    var i = va.id;

    if (document.getElementById(para).checked == true) {
        if (i == "a") {
            $('.ReqForB').removeAttr('required');
            $('.ReqForC').removeAttr('required');
            $('.ReqForD').removeAttr('required');
            document.getElementById("b").checked = false;
            document.getElementById("c").checked = false;
            document.getElementById("d").checked = false;

        } else if (i == "b") {
            $('.ReqForA').removeAttr('required');
            $('.ReqForC').removeAttr('required');
            $('.ReqForD').removeAttr('required');
            document.getElementById("a").checked = false;
            document.getElementById("c").checked = false;
            document.getElementById("d").checked = false;
        } else if (i == "c") {
            $('.ReqForA').removeAttr('required');
            $('.ReqForB').removeAttr('required');
            $('.ReqForD').removeAttr('required');
            document.getElementById("a").checked = false;
            document.getElementById("b").checked = false;
            document.getElementById("d").checked = false;
        } else if (i == "d") {
            $('.ReqForA').removeAttr('required');
            $('.ReqForC').removeAttr('required');
            $('.ReqForD').removeAttr('required');
            document.getElementById("a").checked = false;
            document.getElementById("c").checked = false;
            document.getElementById("b").checked = false;
        }
    }

}
//
// if (document.getElementById("a").cha === true) {
//
//     document.getElementById("b").checked = false;
//     document.getElementById("c").checked = false;
//     document.getElementById("d").checked = false;
//
// }
// else if (document.getElementById("b").checked === true){
//     document.getElementById("a").checked = false;
//     document.getElementById("c").checked = false;
//     document.getElementById("d").checked = false;
//
// }
// else if (document.getElementById("c").checked === true){
//     document.getElementById("a").checked = false;
//     document.getElementById("b").checked = false;
//     document.getElementById("d").checked = false;
//
// }
// else if (document.getElementById("d").checked === true){
//     document.getElementById("a").checked = false;
//     document.getElementById("b").checked = false;
//     document.getElementById("c").checked = false;
// }