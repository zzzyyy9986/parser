<!doctype html>
<html lang="ru">
<head>
    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Тест</title>
</head>
<style>
    .code{
        background: #3b3a46;
        color: orange;
        padding-left: 50px
    }
</style>
<body>
<div id="app" class="container">
    <form @submit.prevent="save" class="mb-2">
        <div class="mb-3">
            <label for="width"  class="form-label">Ширина</label>
            <input  required type="number" class="form-control" v-model="formData.width" id="width"
                   >
        </div>
        <div class="mb-3">
            <label for="height" class="form-label">Высота</label>
            <input required type="number" id="height" class="form-control" v-model="formData.height" >
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Надпись</label>
            <input required id="text" type="text" class="form-control" v-model="formData.text">
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
    <div>
        <pre class="code">
<code v-if="data.length" v-for="person in data" >
    {
    <span v-for="key in Object.keys(person)">
        {{`${key}:${person[key]}`}}
    </span>
    }
</code>
</pre>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@3"></script>
<script>
    const {createApp} = Vue

    createApp({
        data() {
            return {
                message: 'Hello Vue!',
                formData:{
                    width: 0,
                    height: 0,
                    text: "",
                },
                imgTextStyle:{
                    display:"inline-block",
                    fontSize:"14px"
                },
                imgNode:"",
                imgTextNode:"",
                img: "",
                data: ""
            }
        },
        methods: {
            save() {
                this.downloadImg()
            },
            parse() {
                axios.get("/parser.php")
                    .then(resp => {
                        this.data = resp['data'].map(el => {
                            return Object.keys(el).map(key => {
                                return `${key}:${el[key]}<br>`
                            });
                        });
                        this.data = resp['data']
                    })
            },
            downloadImg() {
                let params = Object.keys(this.formData).map(key =>  key + "=" + this.formData[key]).join("&")
                console.log(params)
                axios({
                    url: '/imgCreator.php?' + params,
                    method: "get",
                    responseType: 'blob'
                }).then((response) => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'file.png');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                });
            }
        },
        mounted() {
            this.parse()
            this.imgTextNode = document.getElementById("imgTextNode")
        }
    }).mount('#app')
</script>
</body>
</html>

