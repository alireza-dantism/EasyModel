from modeller import *
import sys

#f = open("aaaa.log", "w")
#f.write(sys.argv[1])
#f.close()

env = Environ()
aln = Alignment(env)
mdl = Model(env, file='jobs/' + sys.argv[1] + '/Template', model_segment=('FIRST:'+sys.argv[2],'LAST:'+sys.argv[2]))
aln.append_model(mdl, align_codes='Template'+sys.argv[2], atom_files='Template.pdb')
aln.append(file='jobs/' + sys.argv[1] + '/Template.ali', align_codes='Model')
aln.align2d(max_gap_length=50)
aln.write(file='jobs/' + sys.argv[1] + '/alignment.ali', alignment_format='PIR')
aln.write(file='jobs/' + sys.argv[1] + '/alignment.pap', alignment_format='PAP')
