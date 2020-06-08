
<!-- Вывод курса -->
<div class="list" data-list-courses>
        <a class="list__link" data-course="1">Ⅰ курс</a>
        <a class="list__link" data-course="2">Ⅱ курс</a>
        <a class="list__link" data-course="3">Ⅲ курс</a>
        <a class="list__link" data-course="4">Ⅳ курс</a>
</div>

<!-- Вывод вариантов -->
<div class="list list-column" data-list-subjects>
        <a class="list__link" data-subject="Экономика">📊 Экономика</a>
        <a class="list__link" data-subject="Приборостроение">⚙ Приборостроение</a>
        <a class="list__link" data-subject="Информатика и вычислительная техника">💻 Информатика и вычислительная техника</a>
</div>
<!-- Вывод кнопки начать -->
<div class="list list-without-border" data-button>
    <button type="button" class="list__button" data-add>Добавить расписание ➕</button>
    <button type="button" class="list__submit" data-start>Изменить расписание 🔧</button>
</div>



<script type="text/javascript">
    
$(document).ready(function() {



    var list_courses = $("div[data-list-courses]");
    var list_subject = $("div[data-list-subjects]");
    var button = $("div[data-button]");


    list_subject.hide();
    button.hide();

    // Выбор Курса
    $("a[data-course]").click(function(e){

        $.cookie('course', $(this).data().course);

        $("a[data-course]").removeClass("active");
        $(this).addClass("active");


        button.hide();
        list_subject.show();

    });

    // Выбор ПРЕДМЕТА
    $("a[data-subject]").click(function(e){
        var subject = $(this).data().subject;
        $.cookie('subject', subject);

        $("a[data-subject]").removeClass("active");
        $(this).addClass("active");

        

        button.show();
    });





    // При нажатии на старт
    $("button[data-start]").click(function(e){
        var course = $.cookie("course");
        var subject = $.cookie("subject");
        if (!course)
            swal({
                title: 'Не выбран тип', 
                text: "Выберите курс в списке",
                timer: 4000,
                icon: "error"
            });
        else if (!subject)
            swal({
                title: 'Не выбран предмет', 
                text: "Выберите предмет в списке",
                timer: 4000,
                icon: "error"
            });
        else
        {
            swal({
                title: 'Все готово!', 
                text: "Начинаем",
                timer: 4000,
                icon: "success"
            }).then(function() {
                location.href = 'timetable';
            });
        }
    });


    // При нажатии на старт
    $("button[data-add]").click(function(e){
        var course = $.cookie("course");
        var subject = $.cookie("subject");
        if (!course)
            swal({
                title: 'Не выбран тип', 
                text: "Выберите курс в списке",
                timer: 4000,
                icon: "error"
            });
        else if (!subject)
            swal({
                title: 'Не выбран предмет', 
                text: "Выберите предмет в списке",
                timer: 4000,
                icon: "error"
            });
        else
        {
            swal({
                title: 'Все готово!', 
                text: "Начинаем",
                timer: 4000,
                icon: "success"
            }).then(function() {
                location.href = 'add/timetable';
            });
        }
    });
});
</script>
