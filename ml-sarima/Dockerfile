# Read the doc: https://huggingface.co/docs/hub/spaces-sdks-docker
# you will also find guides on how best to write your Dockerfile

FROM python:3.9-slim

RUN useradd -m -u 1000 user
USER user
ENV PATH="/home/user/.local/bin:$PATH"

WORKDIR /app

# Copy requirements first for better caching
COPY --chown=user ./requirements.txt requirements.txt
RUN pip install --no-cache-dir --upgrade -r requirements.txt

# Copy the rest of the application
COPY --chown=user . /app

# Expose port 7860 for Hugging Face Spaces
EXPOSE 7860

# Run using gunicorn with timeout to prevent worker crash during model loading
CMD ["gunicorn", "--bind", "0.0.0.0:7860", "--timeout", "120", "src.api:app"]
