# get return angle

```javascript
<script>
        $(document).ready(function (){" "}
        {$("img").click(function () {
                var angle = (($(this).data("angle") || 0) + 90) % 360; //lay 'angle' hien tai
                $(this).css("transform", "rotate(" + angle + "deg)");
                $(this).data("angle", angle); //update
        })}
        )
</script>
```
