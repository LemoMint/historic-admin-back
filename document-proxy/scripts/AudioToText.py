import os
import sys
import whisper
from moviepy.editor import VideoFileClip
from pathlib import Path

def convert_video_to_audio_moviepy(video_file, output_ext="mp3"):
    filename, ext = os.path.splitext(video_file)
    clip = VideoFileClip(video_file)
    clip.audio.write_audiofile(f"{filename}.{output_ext}")

    return f"{filename}.{output_ext}"

def audio2Text(audiofile_path, result_parth):
    model = whisper.load_model("base")
    result = model.transcribe(audiofile_path)

    with open(result_parth, 'w') as f:
        f.write(result["text"])

if __name__ == "__main__":
    af = sys.argv.pop()

    path = Path(af)
    directory = str(path.parent)

    audio2Text(af, directory + "/text.txt")

