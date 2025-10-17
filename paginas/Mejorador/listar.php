<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mejorador de Foto de Perfil</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 1200px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .upload-area {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9ff;
        }
        
        .upload-area:hover {
            border-color: #764ba2;
            background: #f0f2ff;
        }
        
        .upload-area.dragover {
            background: #e8ebff;
            border-color: #764ba2;
        }
        
        .upload-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        input[type="file"] {
            display: none;
        }
        
        .content {
            display: none;
        }
        
        .content.active {
            display: block;
        }
        
        .image-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .image-box {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            background: #fafafa;
        }
        
        .image-box h3 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
            font-size: 16px;
        }
        
        .image-box canvas {
            width: 100%;
            border-radius: 8px;
            display: block;
        }
        
        .controls {
            background: #f8f9ff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .control-group {
            margin-bottom: 20px;
        }
        
        .control-group label {
            display: block;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }
        
        .control-group input[type="range"] {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #d3d3d3;
            outline: none;
            -webkit-appearance: none;
        }
        
        .control-group input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
        }
        
        .control-group input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            border: none;
        }
        
        .value-display {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
            min-width: 45px;
            text-align: center;
        }
        
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        button {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        @media (max-width: 768px) {
            .image-container {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🖼️ Mejorador de Foto de Perfil</h1>
        <p class="subtitle">Mejora tu foto para Computrabajo Paraguay</p>
        
        <div id="uploadArea" class="upload-area">
            <div class="upload-icon">📸</div>
            <h3>Haz clic o arrastra tu foto aquí</h3>
            <p style="color: #666; margin-top: 10px;">Formatos: JPG, PNG</p>
            <input type="file" id="fileInput" accept="image/*">
        </div>
        
        <div id="content" class="content">
            <div class="image-container">
                <div class="image-box">
                    <h3>📷 Imagen Original</h3>
                    <canvas id="originalCanvas"></canvas>
                </div>
                <div class="image-box">
                    <h3>✨ Imagen Mejorada</h3>
                    <canvas id="enhancedCanvas"></canvas>
                </div>
            </div>
            
            <div class="controls">
                <div class="control-group">
                    <label>
                        💡 Brillo 
                        <span class="value-display" id="brightnessValue">110%</span>
                    </label>
                    <input type="range" id="brightness" min="50" max="150" value="110">
                </div>
                
                <div class="control-group">
                    <label>
                        🎨 Contraste 
                        <span class="value-display" id="contrastValue">115%</span>
                    </label>
                    <input type="range" id="contrast" min="50" max="150" value="115">
                </div>
                
                <div class="control-group">
                    <label>
                        🔍 Nitidez 
                        <span class="value-display" id="sharpnessValue">100%</span>
                    </label>
                    <input type="range" id="sharpness" min="0" max="200" value="100">
                </div>
                
                <div class="control-group">
                    <label>
                        🌈 Saturación 
                        <span class="value-display" id="saturationValue">110%</span>
                    </label>
                    <input type="range" id="saturation" min="0" max="200" value="110">
                </div>
                
                <div class="control-group">
                    <label>
                        ❄️ Reducción de Ruido 
                        <span class="value-display" id="denoiseValue">30%</span>
                    </label>
                    <input type="range" id="denoise" min="0" max="100" value="30">
                </div>
            </div>
            
            <div class="buttons">
                <button class="btn-secondary" onclick="resetSettings()">🔄 Restablecer</button>
                <button class="btn-primary" onclick="applyProfessionalPreset()">⚡ Mejora Automática</button>
                <button class="btn-success" onclick="downloadImage()">💾 Descargar Imagen</button>
            </div>
        </div>
    </div>

    <script>
        let originalImage = null;
        let originalCanvas = document.getElementById('originalCanvas');
        let enhancedCanvas = document.getElementById('enhancedCanvas');
        let originalCtx = originalCanvas.getContext('2d');
        let enhancedCtx = enhancedCanvas.getContext('2d');
        
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const content = document.getElementById('content');
        
        uploadArea.addEventListener('click', () => fileInput.click());
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                loadImage(file);
            }
        });
        
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                loadImage(file);
            }
        });
        
        function loadImage(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                originalImage = new Image();
                originalImage.onload = () => {
                    const maxSize = 800;
                    let width = originalImage.width;
                    let height = originalImage.height;
                    
                    if (width > maxSize || height > maxSize) {
                        if (width > height) {
                            height = (height / width) * maxSize;
                            width = maxSize;
                        } else {
                            width = (width / height) * maxSize;
                            height = maxSize;
                        }
                    }
                    
                    originalCanvas.width = width;
                    originalCanvas.height = height;
                    enhancedCanvas.width = width;
                    enhancedCanvas.height = height;
                    
                    originalCtx.drawImage(originalImage, 0, 0, width, height);
                    
                    content.classList.add('active');
                    applyEnhancements();
                };
                originalImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        
        const controls = ['brightness', 'contrast', 'sharpness', 'saturation', 'denoise'];
        controls.forEach(control => {
            const input = document.getElementById(control);
            const valueDisplay = document.getElementById(control + 'Value');
            
            input.addEventListener('input', (e) => {
                valueDisplay.textContent = e.target.value + '%';
                applyEnhancements();
            });
        });
        
        function applyEnhancements() {
            if (!originalImage) return;
            
            const brightness = document.getElementById('brightness').value / 100;
            const contrast = document.getElementById('contrast').value / 100;
            const sharpness = document.getElementById('sharpness').value / 100;
            const saturation = document.getElementById('saturation').value / 100;
            const denoise = document.getElementById('denoise').value / 100;
            
            enhancedCtx.clearRect(0, 0, enhancedCanvas.width, enhancedCanvas.height);
            enhancedCtx.filter = 'none';
            enhancedCtx.drawImage(originalCanvas, 0, 0);
            
            let imageData = enhancedCtx.getImageData(0, 0, enhancedCanvas.width, enhancedCanvas.height);
            let data = imageData.data;
            
            for (let i = 0; i < data.length; i += 4) {
                let r = data[i];
                let g = data[i + 1];
                let b = data[i + 2];
                
                r = ((r / 255 - 0.5) * contrast + 0.5) * 255 * brightness;
                g = ((g / 255 - 0.5) * contrast + 0.5) * 255 * brightness;
                b = ((b / 255 - 0.5) * contrast + 0.5) * 255 * brightness;
                
                const gray = 0.299 * r + 0.587 * g + 0.114 * b;
                r = gray + (r - gray) * saturation;
                g = gray + (g - gray) * saturation;
                b = gray + (b - gray) * saturation;
                
                data[i] = Math.max(0, Math.min(255, r));
                data[i + 1] = Math.max(0, Math.min(255, g));
                data[i + 2] = Math.max(0, Math.min(255, b));
            }
            
            if (denoise > 0) {
                imageData = applyDenoise(imageData, denoise);
            }
            
            if (sharpness > 0) {
                imageData = applySharpen(imageData, sharpness);
            }
            
            enhancedCtx.putImageData(imageData, 0, 0);
        }
        
        function applySharpen(imageData, amount) {
            const pixels = imageData.data;
            const width = imageData.width;
            const height = imageData.height;
            const kernel = [
                0, -1 * amount, 0,
                -1 * amount, 1 + 4 * amount, -1 * amount,
                0, -1 * amount, 0
            ];
            
            const output = new Uint8ClampedArray(pixels.length);
            
            for (let y = 1; y < height - 1; y++) {
                for (let x = 1; x < width - 1; x++) {
                    for (let c = 0; c < 3; c++) {
                        let sum = 0;
                        for (let ky = -1; ky <= 1; ky++) {
                            for (let kx = -1; kx <= 1; kx++) {
                                const idx = ((y + ky) * width + (x + kx)) * 4 + c;
                                const kernelIdx = (ky + 1) * 3 + (kx + 1);
                                sum += pixels[idx] * kernel[kernelIdx];
                            }
                        }
                        const idx = (y * width + x) * 4 + c;
                        output[idx] = Math.max(0, Math.min(255, sum));
                    }
                    const idx = (y * width + x) * 4 + 3;
                    output[idx] = pixels[idx];
                }
            }
            
            for (let i = 0; i < pixels.length; i += 4) {
                if (output[i] > 0 || output[i + 1] > 0 || output[i + 2] > 0) {
                    pixels[i] = output[i];
                    pixels[i + 1] = output[i + 1];
                    pixels[i + 2] = output[i + 2];
                }
            }
            
            return imageData;
        }
        
        function applyDenoise(imageData, amount) {
            const pixels = imageData.data;
            const width = imageData.width;
            const height = imageData.height;
            const radius = Math.floor(amount * 2);
            
            const output = new Uint8ClampedArray(pixels.length);
            
            for (let y = 0; y < height; y++) {
                for (let x = 0; x < width; x++) {
                    let r = 0, g = 0, b = 0, count = 0;
                    
                    for (let dy = -radius; dy <= radius; dy++) {
                        for (let dx = -radius; dx <= radius; dx++) {
                            const ny = y + dy;
                            const nx = x + dx;
                            
                            if (ny >= 0 && ny < height && nx >= 0 && nx < width) {
                                const idx = (ny * width + nx) * 4;
                                r += pixels[idx];
                                g += pixels[idx + 1];
                                b += pixels[idx + 2];
                                count++;
                            }
                        }
                    }
                    
                    const idx = (y * width + x) * 4;
                    output[idx] = r / count;
                    output[idx + 1] = g / count;
                    output[idx + 2] = b / count;
                    output[idx + 3] = pixels[idx + 3];
                }
            }
            
            for (let i = 0; i < pixels.length; i++) {
                pixels[i] = output[i];
            }
            
            return imageData;
        }
        
        function resetSettings() {
            document.getElementById('brightness').value = 110;
            document.getElementById('contrast').value = 115;
            document.getElementById('sharpness').value = 100;
            document.getElementById('saturation').value = 110;
            document.getElementById('denoise').value = 30;
            
            document.getElementById('brightnessValue').textContent = '110%';
            document.getElementById('contrastValue').textContent = '115%';
            document.getElementById('sharpnessValue').textContent = '100%';
            document.getElementById('saturationValue').textContent = '110%';
            document.getElementById('denoiseValue').textContent = '30%';
            
            applyEnhancements();
        }
        
        function applyProfessionalPreset() {
            document.getElementById('brightness').value = 115;
            document.getElementById('contrast').value = 120;
            document.getElementById('sharpness').value = 130;
            document.getElementById('saturation').value = 115;
            document.getElementById('denoise').value = 40;
            
            document.getElementById('brightnessValue').textContent = '115%';
            document.getElementById('contrastValue').textContent = '120%';
            document.getElementById('sharpnessValue').textContent = '130%';
            document.getElementById('saturationValue').textContent = '115%';
            document.getElementById('denoiseValue').textContent = '40%';
            
            applyEnhancements();
        }
        
        function downloadImage() {
            const link = document.createElement('a');
            link.download = 'foto_perfil_mejorada.png';
            link.href = enhancedCanvas.toDataURL('image/png', 1.0);
            link.click();
        }
    </script>
</body>
</html>