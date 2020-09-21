
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
            <canvas id="canvas" width="1500" height="1000"></canvas>
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
            var scaleX     = 75;
            var scaleY     = 75;
            var newline    = 0.125;

            // reset Canvas
            canvas.width = canvas.width;
            canvas.height = canvas.height;


            ctx.lineWidth = (2 / Math.max(scaleX, scaleY)); // scales down draw line
            ctx.scale(scaleX, scaleY);                      // scales up size of shapes
            // ctx.fillStyle = "rgb(200, 0, 200)";
            
            // Loop through items and draw them.
            for(let i = 0; i < printItems.length; i++){

                ctx.strokeStyle  = "#"+((1<<24)*Math.random()|0).toString(16);


                ctx.strokeRect(
                    printItems[i].x_pos,
                    printItems[i].y_pos,
                    printItems[i].width,
                    printItems[i].height,
                );

                ctx.restore();
                ctx.textBaseline = 'middle';
                ctx.textAlign = "center";
                ctx.fillStyle = "black";
                ctx.font = "0.00925em sans-serif";
                ctx.fillText(
                    printItems[i].size, 
                    printItems[i].x_pos + (printItems[i].width / 2), 
                    printItems[i].y_pos + (printItems[i].height / 2)
                );

                ctx.fillText(
                    printItems[i].order_items.products.title, 
                    printItems[i].x_pos + (printItems[i].width / 2), 
                    (printItems[i].y_pos + newline) + (printItems[i].height / 2)
                );

                ctx.fillText(
                    printItems[i].order_items.orders.order_number, 
                    printItems[i].x_pos + (printItems[i].width / 2), 
                    (printItems[i].y_pos + (newline * 2)) + (printItems[i].height / 2)
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