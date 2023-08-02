import '../sass/tabler.scss';
import './bootstrap';
import './tabler-init';
$('.numeric').bind('keyup paste', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});