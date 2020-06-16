$(function(){
    $(".form_money").on("submit", function(){
        $(".input_money").each((index, element) => {
            element.value = element.value.replace(/[¥,]/g, "")
        })
    })

    $(".input_money").maskMoney({
        prefix:"¥",
        thousands:",",
        allowZero:true,
        precision:"0",
    })
        .maskMoney("mask")
})
