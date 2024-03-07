import sys
from spleeter.separator import Separator

def split_audio(input_file, output_directory):
    separator = Separator('spleeter:2stems')
    separator.separate_to_file(input_file, output_directory)

if __name__ == "__main__":
    input_file = sys.argv[1]
    output_directory = sys.argv[2]
    split_audio(input_file, output_directory)
