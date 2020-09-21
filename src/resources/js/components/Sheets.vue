
<template>
    <div class="sheet-container">
        <h2>SHEETS</h2>
        <div class="sheet-list">
            <ul>
                <li
                     v-for='sheet in sheets'
                     :key="sheet._id"
                     @click="drawSheet(sheet)"
                >
                {{ sheet.sheet_url }}
                </li>
            </ul>
        </div>

        <div class="sheet-canvas">
            <canvas id="canvas" width="1000" height="1500"></canvas>
        </div>
    </div>
</template>

<script>

export default {
    data () {
        return {
            sheets: []
        }
    },
    mounted(){
       this.fetch();
    },
    methods: {
        drawSheet(sheet){
            console.log(sheet);

            var canvas     = document.getElementById('canvas');
            var ctx        = canvas.getContext('2d');

            
            var printItems = sheet.print_sheet_items;
            var scaleX     = 50;
            var scaleY     = 50;


            // reset Canvas
            canvas.width = canvas.width;
            canvas.height = canvas.height;


            ctx.lineWidth = (2 / Math.max(scaleX, scaleY)); // scales down draw line
            ctx.scale(scaleX, scaleY);                      // scales up size of shapes
            // ctx.fillStyle = "rgb(200, 0, 200)";
            
            // Loop through items and draw them.
            for(let i = 0; i < printItems.length; i++){

                ctx.strokeStyle  = "#"+((1<<24)*Math.random()|0).toString(16);


                // image 
                // var img = new Image;
                // img.src = printItems[i].order_items.products.design_url;

                // ctx.drawImage(
                //     img,
                //     printItems[i].x_pos,
                //     printItems[i].y_pos,
                //     printItems[i].width,
                //     printItems[i].height
                // );

                ctx.strokeRect(
                    printItems[i].x_pos,
                    printItems[i].y_pos,
                    printItems[i].width,
                    printItems[i].height,
                );
            }
        },
        fetch(){
             axios.get('/api/sheets')
            .then((response) => {
                this.sheets = response.data;
                console.log(response.data);
            });
        }
    }
}
</script>