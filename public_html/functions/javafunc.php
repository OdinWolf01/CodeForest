<script>
function monthName(num){
if(num==0) return 'Jan'; else if(num==1) return 'Feb'; else if(num==2) return 'Mar'; else if(num==3) return 'Apr'; else if(num==4) return 'May'; else if(num==5) return 'Jun'; else if(num==6) return 'Jul'; else if(num==7) return 'Aug'; else if(num==8) return 'Sep'; else if(num==9) return 'Oct'; else if(num==10) return 'Nov'; else if(num==11) return 'Dec';
}
function getSecAgo(e) {
  var n = Math.floor((new Date).getTime() / 1e3 - e),
    o = Math.floor(n / 31536e3);
  return o > 0 ? 1 == o ? "1 year ago" : o + " years ago" : (o = Math.floor(n / 2628e3)) > 0 ? 1 == o ? "1 month ago" : o + " months ago" : (o = Math.floor(n / 86400)) > 0 ? 1 == o ? "1 day ago" : o + " days ago" : (o = Math.floor(n / 3600)) > 0 ? 1 == o ? "1 hour ago" : o + " hours ago" : (o = Math.floor(n / 60)) > 0 ? 1 == o ? "1 minute ago" : o + " minutes ago" : Math.floor(n) + " seconds ago"
}
function getAMorPM(num){
  return (num<12)?'AM':'PM';
}
function get12hour(num){
  return (num==0)?'12':(num>12)?''+(num-12):''+num;
}
function fixZeros(str){
  return ((''+str).length==1)?'0'+str:''+str;
}
</script>