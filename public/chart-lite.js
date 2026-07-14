(function () {
    function asArray(value) {
        return Array.isArray(value) ? value : [];
    }

    function pickColor(colors, index, fallback) {
        if (Array.isArray(colors)) return colors[index % colors.length] || fallback;
        return colors || fallback;
    }

    function getCanvas(target) {
        if (typeof target === 'string') return document.getElementById(target);
        return target;
    }

    function drawAxes(ctx, width, height, padding) {
        ctx.strokeStyle = '#e5e7eb';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(padding.left, padding.top);
        ctx.lineTo(padding.left, height - padding.bottom);
        ctx.lineTo(width - padding.right, height - padding.bottom);
        ctx.stroke();
    }

    function drawLabels(ctx, labels, width, height, padding) {
        const plotWidth = width - padding.left - padding.right;
        ctx.fillStyle = '#64748b';
        ctx.font = '12px system-ui, -apple-system, Segoe UI, sans-serif';
        ctx.textAlign = 'center';
        labels.forEach(function (label, index) {
            const x = padding.left + (plotWidth / Math.max(labels.length, 1)) * (index + 0.5);
            const text = String(label).length > 12 ? String(label).slice(0, 11) + '…' : String(label);
            ctx.fillText(text, x, height - 12);
        });
    }

    function normalizeCanvas(canvas) {
        const ratio = window.devicePixelRatio || 1;
        const cssWidth = canvas.clientWidth || canvas.parentElement.clientWidth || 600;
        const cssHeight = Number(canvas.getAttribute('height')) || 220;
        canvas.style.width = '100%';
        canvas.style.height = cssHeight + 'px';
        canvas.width = Math.max(1, Math.floor(cssWidth * ratio));
        canvas.height = Math.max(1, Math.floor(cssHeight * ratio));
        const ctx = canvas.getContext('2d');
        ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
        return { ctx: ctx, width: cssWidth, height: cssHeight };
    }

    function Chart(target, config) {
        this.canvas = getCanvas(target);
        this.config = config || {};
        this.render();
    }

    Chart.prototype.render = function () {
        if (!this.canvas || !this.canvas.getContext) return;
        const normalized = normalizeCanvas(this.canvas);
        const ctx = normalized.ctx;
        const width = normalized.width;
        const height = normalized.height;
        const padding = { top: 22, right: 18, bottom: 38, left: 36 };
        const data = this.config.data || {};
        const labels = asArray(data.labels);
        const dataset = asArray(data.datasets)[0] || {};
        const values = asArray(dataset.data).map(function (value) { return Number(value) || 0; });
        const max = Math.max.apply(null, values.concat([1]));
        const plotWidth = width - padding.left - padding.right;
        const plotHeight = height - padding.top - padding.bottom;

        ctx.clearRect(0, 0, width, height);
        drawAxes(ctx, width, height, padding);

        ctx.fillStyle = '#64748b';
        ctx.font = '12px system-ui, -apple-system, Segoe UI, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText(String(max), padding.left - 8, padding.top + 4);
        ctx.fillText('0', padding.left - 8, height - padding.bottom + 4);

        if ((this.config.type || 'bar') === 'line') {
            ctx.strokeStyle = dataset.borderColor || '#b91c1c';
            ctx.fillStyle = dataset.backgroundColor || 'rgba(185,28,28,.12)';
            ctx.lineWidth = 3;
            ctx.beginPath();
            values.forEach(function (value, index) {
                const x = padding.left + (plotWidth / Math.max(values.length - 1, 1)) * index;
                const y = height - padding.bottom - (value / max) * plotHeight;
                if (index === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
            });
            ctx.stroke();

            values.forEach(function (value, index) {
                const x = padding.left + (plotWidth / Math.max(values.length - 1, 1)) * index;
                const y = height - padding.bottom - (value / max) * plotHeight;
                ctx.beginPath();
                ctx.arc(x, y, 4, 0, Math.PI * 2);
                ctx.fillStyle = dataset.borderColor || '#b91c1c';
                ctx.fill();
            });
        } else {
            const gap = 12;
            const barWidth = Math.max(18, (plotWidth - gap * Math.max(values.length - 1, 0)) / Math.max(values.length, 1));
            values.forEach(function (value, index) {
                const x = padding.left + index * (barWidth + gap) + Math.max(0, (plotWidth - (barWidth * values.length + gap * (values.length - 1))) / 2);
                const barHeight = (value / max) * plotHeight;
                const y = height - padding.bottom - barHeight;
                ctx.fillStyle = pickColor(dataset.backgroundColor, index, '#b91c1c');
                ctx.beginPath();
                ctx.roundRect ? ctx.roundRect(x, y, barWidth, barHeight, 8) : ctx.rect(x, y, barWidth, barHeight);
                ctx.fill();
            });
        }

        drawLabels(ctx, labels, width, height, padding);
    };

    window.Chart = Chart;
})();
